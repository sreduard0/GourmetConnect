<?php

namespace App\Http\Controllers;

use App\Classes\Calculate;
use App\Classes\Tools;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // CRIANDO COMANDA
    public function create(Request $request)
    {
        $tableData = $request->all();
        $order = RequestsModel::where('table', $tableData['table'])->where('client_name', $tableData['client_name'])->where('status', 1)->where('delivery', 0)->first();
        if ($order) {
            return [
                'error' => false,
                'order' => Tools::hash($order->id, 'encrypt'),
            ];

        } else {
            try {
                $order = new RequestsModel();
                $order->table = $tableData['table'];
                $order->client_name = $tableData['client_name'];
                $order->status = 1;
                $order->save();
                return [
                    'error' => false,
                    'order' => Tools::hash($order->id, 'encrypt'),
                ];

            } catch (\Throwable$th) {
                return [
                    'error' => true,
                    'message' => 'Erro ao criar comanda',
                ];
            }
        }

    }
    // DELETANDO COMANDA
    public function delete($id)
    {
        try {
            RequestsItemsModel::where('request_id', Tools::hash($id, 'decrypt'))->delete();
            RequestsModel::find(Tools::hash($id, 'decrypt'))->delete();
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
    // LISTA COMANDAS DA MESA
    public function table_orders_list($table)
    {
        $requests = RequestsModel::select('client_name')->where('table', $table)->where('status', 1)->where('delivery', 0)->get();
        $clients = [];
        foreach ($requests as $client) {
            $clients[] = $client->client_name;
        }
        return $clients;
    }
    // INFORMAÇÕES DA CAMANDA
    public function order_information($id)
    {
        $requestData = RequestsModel::find(Tools::hash($id, 'decrypt'));
        $requestItems = RequestsItemsModel::where('request_id', Tools::hash($id, 'decrypt'))->where('status', 2)->exists();
        $data = [
            'table' => $requestData->table,
            'client' => $requestData->client_name,
            'total' => Calculate::requestValue(Tools::hash($id, 'decrypt'), [1, 3], false, true),
            'pending' => $requestItems,
        ];
        return $data;
    }
    // VERIFICA SE A COMANDA FOI FINALIZADA
    public function check_order_finish($id)
    {
        if (RequestsModel::find(Tools::hash($id, 'decrypt'))) {
            return 'true';
        }
    }
    // TABELA DATATABLES COM TODAS COMANDAS
    public function table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'client_name',
            2 => 'table',
            3 => 'created_at',
            4 => 'value',
            5 => 'id',
        );

        if ($requestData['columns'][1]['search']['value']) {
            $query = RequestsModel::query();
            if ($requestData['columns'][1]['search']['value']) {
                $query->where('table', $requestData['columns'][1]['search']['value']);
            }
            $query_rows = $query;
            $rows = $query_rows->count();

            $requests = $query->where('status', 1)->where('delivery', 0)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
        } else {
            $requests = RequestsModel::with('request_items')->where('status', 1)->where('delivery', 0)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = RequestsModel::where('status', 1)->count();
        }
        $filtered = count($requests);
        $dados = array();
        foreach ($requests as $request) {
            $buttons = '';
            if (Auth::user()->hasPermissionTo('view_orders')) {
                $buttons .= '<button onclick="return requests_client_view_modal(\'' . Tools::hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-default" ><i class="fa-solid fa-eye"></i></button> ';
            }
            if (Auth::user()->hasPermissionTo('delete_order')) {
                $buttons .= '<button onclick="return delete_order(\'' . Tools::hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button> ';
            }
            if (Auth::user()->hasPermissionTo('finalize_order')) {
                $buttons .= '<a class="btn btn-sm btn-success" href="' . route('close-request', ['id' => Tools::hash($request->id, 'encrypt')]) . '"><i class="fa-solid fa-check"></i></a>';
            }
            $dado = array();
            $dado[] = "#" . $request->id;
            $dado[] = $request->client_name;
            $dado[] = $request->table;
            $dado[] = $request->request_items ? 'SIM' : 'NÃO';
            $dado[] = Calculate::requestValue($request->id, [2, 3], false, true);
            $dado[] = $buttons;
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows),
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }

}
