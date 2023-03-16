<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\ItemModel;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
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
                'product_id' => $this->Tools->hash($data['item'], 'decrypt'),
                'request_id' => $request->id,
                'amount' => 1,
                'value' => $product->value,
            ];
        }

        RequestsItemsModel::insert($requestItems);
        print_r($requestItems);
        // if (isset($requestSave)) {
        //     RequestsItemsModel::create($requestSave);
        // }
        // return 'success';
    }
// INFORMAÇÕES DO PEDIDO
    public function client_table(Request $request)
    {
        $table = $request->all();
        $requests = RequestsModel::select('client_name')->where('table', $table['number'])->get();
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
            2 => 'amount',
            3 => 'value',
            4 => 'id',
        );

        if ($requestData['columns'][1]['search']['value'] && $requestData['columns'][2]['search']['value']) {
            $request = RequestsModel::where('table', $requestData['columns'][1]['search']['value'])->where('client_name', $requestData['columns'][2]['search']['value'])->first();
            if (empty($request)) {
                $request = new RequestsModel();
                $request->table = $requestData['columns'][1]['search']['value'];
                $request->client_name = $requestData['columns'][2]['search']['value'];
                $request->save();
            }

            $items = RequestsItemsModel::with('product')->where('request_id', $request->id)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();

            $rows = RequestsItemsModel::where('request_id', $request->id)->count();

        } else {
            $items = array();
            $rows = 0;
        }

        $filtered = count($items);
        $dados = array();

        foreach ($items as $item) {
            $dado = array();
            $dado[] = "#" . $item->id;
            $dado[] = '<img class="img-circle" src="' . asset($item->product->photo_url) . '" alt="" width="35">';
            $dado[] = $item->product->name;
            $dado[] = $item->amount;
            $dado[] = 'R$' . number_format($item->value, 2, ',', '.');
            $dado[] = '<button onclick="return modal_additional_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return delete_additional_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
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

        if ($requestData['columns'][1]['search']['value']) {
            $request = RequestsModel::where('table', $requestData['columns'][1]['search']['value'])->where('client_name', $requestData['columns'][2]['search']['value'])->first();
            if (empty($request)) {
                $request = new RequestsModel();
                $request->table = $requestData['columns'][1]['search']['value'];
                $request->client_name = $requestData['columns'][2]['search']['value'];
                $request->save();
            }

            $items = RequestsItemsModel::with('product')->where('request_id', $request->id)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();

            $rows = RequestsItemsModel::where('request_id', $request->id)->count();

        } else {
            $requests = RequestsModel::orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();

            $rows = RequestsItemsModel::all()->count();

        }

        $filtered = count($requests);
        $dados = array();

        foreach ($requests as $request) {
            $dado = array();
            $dado[] = "#" . $request->id;
            $dado[] = $request->client_name;
            $dado[] = $request->table;
            $dado[] = 'R$' . number_format(500.00, 2, ',', '.');
            $dado[] = '<button onclick="return modal_additional_item(\'' . $this->Tools->hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return delete_additional_item(\'' . $this->Tools->hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
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
                ->with('type')
                ->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = count(ItemModel::where('type_id', $requestData['columns'][1]['search']['value'])->get());
        } else {
            $items = ItemModel::with('type')->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
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
