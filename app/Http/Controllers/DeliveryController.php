<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // FERRAMENTAS
    private $Tools;
    public function __construct()
    {
        $this->Tools = new Tools;
    }
// INFORMAÇOES DO DELIVERY
    public function delivery_client_view(Request $request)
    {
        $id = $request->get('id');

        $requestData = RequestsModel::find($this->Tools->hash($id, 'decrypt'));
        $requestItems = RequestsItemsModel::where('request_id', $this->Tools->hash($id, 'decrypt'))->where('status', 2)->exists();
        $data = [
            'status' => $requestData->status,
            'client' => $requestData->client_name,
            'total' => $this->Tools->sum_values_requests($this->Tools->hash($id, 'decrypt')),
        ];
        return $data;
    }

// TABELAS
    public function delivery_table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'client_name',
            2 => 'id',
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

            $requests = $query->where('status', 1)->orderBy('status', 'asc')
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
        } else {
            $requests = RequestsModel::where('status', 1)->where('delivery', 1)->orderBy('status', 'asc')
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = RequestsModel::where('status', 1)->count();
        }
        $filtered = count($requests);
        $dados = array();
        foreach ($requests as $request) {
            switch ($request->status) {
                case 1:
                    $status = 'Novo';
                    break;
                case 2:
                    $status = 'Em andamento';
                    break;
            }
            $dado = array();
            $dado[] = "#" . $request->id;
            $dado[] = $request->client_name;
            $dado[] = $request->address->neighborhood;
            $dado[] = $status;
            $dado[] = $this->Tools->sum_values_requests($request->id);
            $dado[] = '<button onclick="return delivery_client_view_modal(\'' . $this->Tools->hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-default" ><i class="fa-solid fa-eye"></i></button> <button onclick="return delete_request(\'' . $this->Tools->hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button> <a class="btn btn-sm btn-success" href="' . route('close-request', ['id' => $this->Tools->hash($request->id, 'encrypt')]) . '"><i class="fa-solid fa-check"></i></a>';
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
