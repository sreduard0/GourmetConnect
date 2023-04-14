<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\DeliveryAddressModel;
use App\Models\DeliveryLocationsModel;
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
// CRUD
    public function new_delivery(Request $request)
    {
        $deliveryData = $request->all();
        $check = RequestsModel::where('client_name', $deliveryData['client'])->where('delivery', 1)->where('status', 1)->first();
        if ($check) {
            if (DeliveryAddressModel::where('request_id', $check->id)->where('street_address', $deliveryData['address'])->where('number', $deliveryData['number'])->where('neighborhood', $deliveryData['neighborhood'])->where('reference', $deliveryData['reference'])->where('delivered', 0)->exists()) {
                return 'exists';
            }
        }
        $delivery_location = DeliveryLocationsModel::find($deliveryData['location']);
        $delivery = new RequestsModel();
        $delivery->delivery = 1;
        $delivery->client_name = strtoupper($deliveryData['client']);
        $delivery->payment_method = $deliveryData['payment'];
        $delivery->status = 1;
        if ($delivery->save()) {
            $delivery_address = new DeliveryAddressModel;
            $delivery_address->request_id = $delivery->id;
            $delivery_address->location_id = $deliveryData['location'];
            $delivery_address->recipient_name = strtoupper($deliveryData['client']);
            $delivery_address->street_address = $deliveryData['address'];
            $delivery_address->neighborhood = $deliveryData['neighborhood'];
            $delivery_address->phone = str_replace(['(', ')', '-', ' '], '', $deliveryData['phone']);
            $delivery_address->reference = $deliveryData['reference'];
            $delivery_address->number = str_replace('_', '', $deliveryData['number']);
            $delivery_address->delivery_value = $delivery_location->value_delivery;
            if ($delivery_address->save()) {
                return $this->Tools->hash($delivery->id, 'encrypt');
            } else {
                RequestsModel::find($delivery->id)->delete();
                return 'error';
            }
            return $this->Tools->hash($delivery->id, 'encrypt');
        }
    }
    public function alt_status(Request $request)
    {
        RequestsModel::where('id', $this->Tools->hash($request->get('id'), 'decrypt'))->where('status', 2)->update(['status' => 3]);
    }
    public function finalize_delivery(Request $request)
    {
        $delivery = RequestsModel::find($this->Tools->hash($request->get('id'), 'decrypt'));
        if ($delivery->update(['status' => 4])) {
            RequestsItemsModel::where('request_id', $this->Tools->hash($request->get('id'), 'decrypt'))->where('status', 3)->update(['status' => 4, 'payment_method' => $delivery->payment_method]);
            RequestsItemsModel::where('request_id', $this->Tools->hash($request->get('id'), 'decrypt'))->where('status', 2)->delete();
        }
    }
// INFORMAÇOES DO DELIVERY
    public function delivery_client_view(Request $request)
    {
        $id = $request->get('id');
        $requestData = RequestsModel::find($this->Tools->hash($id, 'decrypt'));

        switch ($requestData->status) {
            case 1:
                $status = 'NOVO PEDIDO';
                $btn = '<button type="button" onclick="print_request(\'' . $this->Tools->hash($requestData->id, 'encrypt') . '\')" class="btn btn-info rounded-pill float-right m-t-10"><strong>IMPRIMIR PEDIDO</strong></button>';
                $edit_btn = '<button class="btn btn-accent rounded-pill" onclick="edit_delivery(\'' . $this->Tools->hash($requestData->id, 'encrypt') . '\',\'' . $requestData->client_name . '\')"><i class="fa-solid fa-pen"></i><strong> EDITAR PEDIDO</strong></button>';
                break;
            case 2:
                $status = 'EM ANDAMENTO';
                $btn = '<button type="button" onclick="alt_status(\'' . $this->Tools->hash($requestData->id, 'encrypt') . '\')" class="btn btn-primary rounded-pill float-right m-t-10"><strong>SAIU PARA ENTREGA</strong></button>';
                $edit_btn = '';

                break;
            case 3:
                $status = 'SAIU PARA ENTREGA';
                $btn = '<button type="button" onclick="finalize_delivery(\'' . $this->Tools->hash($requestData->id, 'encrypt') . '\')" class="btn btn-success rounded-pill float-right m-t-10"><strong>FINALIZAR PEDIDO</strong></button>';
                $edit_btn = '';
                break;
        }
        $delivery_address = DeliveryAddressModel::where('request_id', $this->Tools->hash($id, 'decrypt'))->first();
        $data = [
            'status' => $status,
            'address' => $delivery_address->street_address . ", " . $delivery_address->number . " - " . $delivery_address->neighborhood,
            'payment' => $requestData->payment->name,
            'btn' => $btn,
            'edit' => $edit_btn,
            'value' => number_format($delivery_address->delivery_value, 2, ',', '.'),
            'value_total' => $this->Tools->sum_values_requests($requestData->id, $delivery_address->delivery_value),
            'client' => $requestData->client_name,
            'total' => $this->Tools->sum_values_requests($this->Tools->hash($id, 'decrypt')),
        ];
        return $data;
    }

// TABELAS
    public function delivery_table(Request $request)
    {
        $deliveryData = $request->all();
        if ($deliveryData['columns'][1]['search']['value']) {

            $delivery_for_location = DeliveryAddressModel::select('request_id')->where('location_id', $deliveryData['columns'][1]['search']['value'])->where('delivered', 0)->get();
            $deliverys = RequestsModel::whereIn('id', $delivery_for_location)->whereIn('status', [1, 2, 3])->where('delivery', 1)->orderBy('status', 'asc')
                ->offset($deliveryData['start'])
                ->take($deliveryData['length'])
                ->get();
            $rows = RequestsModel::whereIn('id', $delivery_for_location)->where('status', 1)->where('delivery', 1)->count();

        } else {
            $deliverys = RequestsModel::whereIn('status', [1, 2, 3])->where('delivery', 1)->orderBy('status', 'asc')
                ->offset($deliveryData['start'])
                ->take($deliveryData['length'])
                ->get();
            $rows = RequestsModel::where('status', 1)->where('delivery', 1)->count();
        }
        $filtered = count($deliverys);
        $dados = array();
        foreach ($deliverys as $delivery) {
            switch ($delivery->status) {
                case 1:
                    $status = 'Novo';
                    $btns = '<button onclick="return delivery_client_view_modal(\'' . $this->Tools->hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-default" ><i class="fa-solid fa-eye"></i></button> <button onclick="return delete_delivery(\'' . $this->Tools->hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button> <button onclick="return print_request(\'' . $this->Tools->hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-info"><i class="fa-solid fa-print"></i></button>';

                    break;
                case 2:
                    $status = 'Em andamento';
                    $btns = '<button onclick="return delivery_client_view_modal(\'' . $this->Tools->hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-default" ><i class="fa-solid fa-eye"></i></button> <button onclick="return delete_delivery(\'' . $this->Tools->hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button> <button onclick="return alt_status(\'' . $this->Tools->hash($delivery->id, 'encrypt') . '\',\'' . $this->Tools->hash(3, 'encrypt') . '\')" class="btn btn-sm btn-primary"><i class="fa-solid fa-moped"></i></button>';

                    break;
                case 3:
                    $status = 'Saiu para entrega';
                    $btns = '<button onclick="return delivery_client_view_modal(\'' . $this->Tools->hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-default" ><i class="fa-solid fa-eye"></i></button> <button onclick="return delete_delivery(\'' . $this->Tools->hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button> <button onclick="return finalize_delivery(\'' . $this->Tools->hash($delivery->id, 'encrypt') . '\',\'' . $this->Tools->hash(4, 'encrypt') . '\')" class="btn btn-sm btn-success"><i class="fa-solid fa-check"></i></button>';

                    break;
            }
            $dado = array();
            $dado[] = "#" . $delivery->id;
            $dado[] = $delivery->client_name;
            $dado[] = $delivery->address->neighborhood;
            $dado[] = $status;
            $dado[] = $this->Tools->sum_values_requests($delivery->id, $delivery->address->delivery_value);
            $dado[] = $btns;
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($deliveryData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows),
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }
    // TABELA COM OS PEDIDOS DO DO CLIENTE SENDO FEITOS
    public function delivery_client_table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'product_id',
            2 => 'value',
            3 => 'status',
            4 => 'id',
        );

        if ($requestData['columns'][1]['search']['value']) {
            $items = RequestsItemsModel::with('product')->where('request_id', $this->Tools->hash($requestData['columns'][1]['search']['value'], 'decrypt'))->where('status', 1)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();

            $rows = RequestsItemsModel::where('request_id', $this->Tools->hash($requestData['columns'][1]['search']['value'], 'decrypt'))->where('status', 1)->count();

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
