<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AdditionalItemModel;
use App\Models\ItemModel;
use App\Models\RequestAdditionalItemModal;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
// FERRAMENTAS
    private $Tools;
    public function __construct()
    {
        $this->Tools = new Tools;
    }
// PEDIDO DO CLIENTE
    public function add_item_request(Request $request)
    {
        $data = $request->all();
        $request = RequestsModel::select('id')->where('table', $data['table'])->where('client_name', $data['client'])->first();
        $product = ItemModel::select('value')->find($this->Tools->hash($data['item'], 'decrypt'));

        for ($i = 1; $i <= $data['amount']; $i++) {
            $requestItems[] = [
                'request_id' => $request->id,
                'product_id' => $this->Tools->hash($data['item'], 'decrypt'),
                'status' => 1,
                'value' => $product->value,
            ];
        }
        if (isset($requestItems)) {
            RequestsItemsModel::insert($requestItems);
        }
        return 'success';
    }
    public function send_item_request(Request $request)
    {
        $data = $request->all();
        $request = RequestsModel::select('id')->where('table', $data['table'])->where('client_name', $data['client'])->first();

        if (RequestsItemsModel::where('request_id', $request->id)->where('status', 1)->update(['waiter' => session('user')['name'], 'status' => 2])) {
            return 'success';
        } else {
            return 'not-send';
        }
    }
    public function delete_item_request(Request $request)
    {
        $data = $request->all();
        if (RequestsItemsModel::where('id', $this->Tools->hash($data['item'], 'decrypt'))->where('status', 1)->delete()) {
            return 'success';
        } else {
            return 'not-delete';
        }
    }
    public function additionals_items_request(Request $request)
    {
        $data = $request->all();
        $itemsCheck = RequestAdditionalItemModal::where('item_id', $this->Tools->hash($data['request_id'], 'decrypt'))->get();
        $items = AdditionalItemModel::where('item_id', $this->Tools->hash($data['item'], 'decrypt'))->get();
        $observation = RequestsItemsModel::select('observation')->find($this->Tools->hash($data['request_id'], 'decrypt'));

        $additionalItems['observation'] = $observation->observation;
        $additionalItems['items'] = [];
        foreach ($items as $item) {
            $additionalItems['items'][$item->id] = [
                'id' => $item->id,
                'name' => $item->name,
                'value' => $item->value,
                'check' => '',
            ];
            foreach ($itemsCheck as $itemCheck) {
                if ($item->id === $itemCheck->additional_id) {
                    $additionalItems['items'][$item->id] = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'value' => $item->value,
                        'check' => 'checked',
                    ];
                }
            }
        }
        return $additionalItems;
    }
    public function save_obs_item_request(Request $request)
    {
        $inputs = $request->all();
        foreach ($inputs['additionals'] as $input) {
            if ($input['check'] == 'true') {
                $additional = AdditionalItemModel::select('value')->find($input['id']);
                $additionals = [
                    'additional_id' => $input['id'],
                    'item_id' => $this->Tools->hash($inputs['id'], 'decrypt'),
                    'value' => $additional->value,
                ];
                RequestAdditionalItemModal::updateOrCreate(['additional_id' => $input['id'], 'item_id' => $this->Tools->hash($inputs['id'], 'decrypt')], $additionals);
            } else {
                RequestAdditionalItemModal::where('additional_id', $input['id'])->where('item_id', $this->Tools->hash($inputs['id'], 'decrypt'))->delete();
            }
        }
        $observation = RequestsItemsModel::find($this->Tools->hash($inputs['id'], 'decrypt'));
        $observation->observation = $inputs['obs'];
        $observation->save();
        return 'success';

    }
// INFORMAÇÕES DO PEDIDO
    public function client_table(Request $request)
    {
        $table = $request->all();
        $requests = RequestsModel::select('client_name')->where('table', $table['number'])->where('status', 1)->get();
        $clients = [];
        foreach ($requests as $client) {
            $clients[] = $client->client_name;
        }
        return $clients;
    }
// TABELAS
    public function request_client_table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'product_id',
            2 => 'value',
            3 => 'status',
            4 => 'id',
        );

        if ($requestData['columns'][1]['search']['value'] && $requestData['columns'][2]['search']['value']) {
            $request = RequestsModel::where('table', $requestData['columns'][1]['search']['value'])
                ->where('client_name', $requestData['columns'][2]['search']['value'])
                ->where('status', 1)->first();
            if (empty($request)) {
                $request = new RequestsModel();
                $request->table = $requestData['columns'][1]['search']['value'];
                $request->client_name = $requestData['columns'][2]['search']['value'];
                $request->status = 1;
                $request->save();
            }

            $items = RequestsItemsModel::with('product')->where('request_id', $request->id)->where('status', 1)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();

            $rows = RequestsItemsModel::where('request_id', $request->id)->where('status', 1)->count();

        } else {
            $items = array();
            $rows = 0;
        }

        $filtered = count($items);
        $dados = array();

        foreach ($items as $item) {
            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($item->product->photo_url) . '" alt="" width="35">';
            $dado[] = $item->product->name;
            $dado[] = $this->Tools->sum_values_item($item->id);
            $dado[] = '<button onclick="return additional_item_request(\'' . $this->Tools->hash($item->product_id, 'encrypt') . '\',\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return  delete_item_request(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger m-t-3"><i class="fa-solid fa-trash"></i></button>';
            // $dado[] = $item->description;'R$' . number_format($item->value, 2, ',', '.')
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }
    public function all_request_table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'client_name',
            2 => 'table',
            3 => 'value',
            4 => 'id',
        );

        if ($requestData['columns'][1]['search']['value'] || $requestData['columns'][2]['search']['value']) {
            $query = RequestsModel::query();
            if ($requestData['columns'][1]['search']['value']) {
                $query->where('table', $requestData['columns'][1]['search']['value']);
            }
            if ($requestData['columns'][2]['search']['value']) {
                $query->where('status', $requestData['columns'][2]['search']['value']);
            }
            $query_rows = $query;
            $rows = $query_rows->count();

            $requests = $query->where('status', 1)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
        } else {
            $requests = RequestsModel::with('request_items')->where('status', 1)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = RequestsModel::where('status', 1)->count();
        }

        $filtered = count($requests);

        $dados = array();
        foreach ($requests as $request) {
            $dado = array();
            $dado[] = "#" . $request->id;
            $dado[] = $request->client_name;
            $dado[] = $request->table;
            $dado[] = $request->request_items ? 'SIM' : 'NÃO';
            $dado[] = $this->Tools->sum_values_requests($request->id);
            $dado[] = '<button onclick="return modal_additional_item(\'' . $this->Tools->hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return delete_additional_item(\'' . $this->Tools->hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
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
    public function table_menu(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'value',
            3 => 'id',
        );

        if ($requestData['columns'][1]['search']['value']) {
            $items = ItemModel::where('type_id', $requestData['columns'][1]['search']['value'])
                ->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = count(ItemModel::where('type_id', $requestData['columns'][1]['search']['value'])->get());
        } else {
            $items = ItemModel::orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = count(ItemModel::all());
        }
        $filtered = count($items);
        $dados = array();
        foreach ($items as $item) {
            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($item->photo_url) . '" alt="' . $item->name . '" width="35">';
            $dado[] = $item->name;
            $dado[] = 'R$' . number_format($item->value, 2, ',', '.');
            $dado[] = '<button onclick="return modal_view_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-secondary" ><i class="fa-solid fa-eye"></i></button> <button onclick="return select_amount_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></button>';
            // $dado[] = $item->description;
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }

}
