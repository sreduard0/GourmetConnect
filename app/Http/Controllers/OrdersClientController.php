<?php

namespace App\Http\Controllers;

use App\Classes\Calculate;
use App\Classes\Tools;
use App\Models\DeliveryAddressModel;
use App\Models\DeliveryLocationsModel;
use App\Models\RequestsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersClientController extends Controller
{
    //--------------------------------------
    // CRUD PEDIDOS JA FEITOS
    //--------------------------------------
    public function edit($id)
    {
        $data = [
            'id' => $id,
            'address' => DeliveryAddressModel::where('request_id', Tools::hash($id, 'decrypt'))->first(),
            'payment' => RequestsModel::select('payment_method')->find(Tools::hash($id, 'decrypt')),

        ];
        return $data;
    }
    public function update(Request $request)
    {
        try {
            $data = $request->all();
            $delivery_value = DeliveryLocationsModel::find($data['address']['location']);
            RequestsModel::find(Tools::hash($data['id'], 'decrypt'))->update(['payment_method' => $data['payment']]);
            $delivery_address = DeliveryAddressModel::where('request_id', Tools::hash($data['id'], 'decrypt'))->first();
            $delivery_address->location_id = $data['address']['location'];
            $delivery_address->street_address = $data['address']['street'];
            $delivery_address->neighborhood = $data['address']['neighborhood'];
            $delivery_address->phone = str_replace(['(', ')', '-', ' '], '', $data['address']['phone']);
            $delivery_address->reference = $data['address']['reference'];
            $delivery_address->number = str_replace('_', '', $data['address']['number']);
            $delivery_address->delivery_value = $delivery_value->value_delivery;
            $delivery_address->save();
            return ['error' => false, 'message' => 'Salvo!'];

        } catch (\Throwable $th) {
            return ['error' => true, 'message' => 'Ouve algum erro, tente novamente.'];
        }

    }
    public function show($id)
    {
        $requestData = RequestsModel::find(Tools::hash($id, 'decrypt'));
        switch ($requestData->status) {
            case 1:
                $status = 'PENDENTE';
                break;
            case 2:
                $status = 'EM ANDAMENTO';
                break;
            case 3:
                $status = 'SAIU PARA ENTREGA';
                break;
        }
        $delivery_address = DeliveryAddressModel::where('request_id', Tools::hash($id, 'decrypt'))->first();
        $data = [
            'status' => $status,
            'address' => $delivery_address->street_address . ", " . $delivery_address->number . " - " . $delivery_address->neighborhood,
            'payment' => $requestData->payment->name,
            'phone' => Tools::mask('(##) # ####-####', $delivery_address->phone),
            'value' => number_format($delivery_address->delivery_value, 2, ',', '.'),
            'value_total' => Calculate::requestValue($requestData->id, [1, 4], true, true),
        ];
        return $data;
    }
    //--------------------------------------
    // OUTRAS FUNÇÕES
    //--------------------------------------
    // CONTAGEM DE PEDIDOS
    public function count_orders()
    {
        $count_orders = RequestsModel::select('status', DB::raw('COUNT(status) as count'))->where('client_id', auth()->guard('client')->id())->where('delivery', 1)->groupBy('status')->get()->toArray();
        $count = [];

        foreach ($count_orders as $orders) {
            if ($orders['status'] == 1) {
                $count['pending']['count'] = $orders['count'];
            }
            if ($orders['status'] == 2) {
                $count['production']['count'] = $orders['count'];
            }
            if ($orders['status'] == 3) {
                $count['send-delivery']['count'] = $orders['count'];
            }
            if ($orders['status'] == 4) {
                $count['finished']['count'] = $orders['count'];
            }
        }
        return $count;

    }

    //---------------------------------------
    // TABELAS
    //---------------------------------------
    // TABELA DE PEDIDOS
    public function orders_table(Request $request)
    {
        $deliveryData = $request->all();
        if ($deliveryData['columns'][1]['search']['value']) {
            switch ($deliveryData['columns'][1]['search']['value']) {
                case 'pending':
                    $status = 1;
                    break;
                case 'production':
                    $status = 2;
                    break;
                case 'send-delivery':
                    $status = 3;
                    break;
                case 'finished':
                    $status = 4;
                    break;
                default:
                    $status = 1;
                    break;
            }
            $deliverys = RequestsModel::where('status', $status)->where('delivery', 1)
                ->where('client_id', auth()->guard('client')->id())
                ->offset($deliveryData['start'])
                ->take($deliveryData['length'])
                ->get();
            $rows = RequestsModel::where('status', $status)->where('delivery', 1)->count();

        } else {
            $deliverys = RequestsModel::where('status', 1)->where('delivery', 1)
                ->where('client_id', auth()->guard('client')->id())
                ->offset($deliveryData['start'])
                ->take($deliveryData['length'])
                ->get();
            $rows = RequestsModel::where('status', 1)->where('delivery', 1)->count();
        }
        $filtered = count($deliverys);
        $dados = array();
        foreach ($deliverys as $delivery) {
            $buttons = '';
            $buttons .= '<button onclick="return items_request(\'' . Tools::hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i></button> ';
            switch ($delivery->status) {
                case 1:
                    $buttons .= '<button onclick="edit_address_or_payment(\'' . Tools::hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-success"><i class="fa-solid fa-pen"></i></button> ';
                    $buttons .= '<button onclick="return delete_delivery(\'' . Tools::hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button> ';
                    break;
                case 2:
                    $buttons .= '<button onclick="edit_address_or_payment(\'' . Tools::hash($delivery->id, 'encrypt') . '\')" class="btn btn-sm btn-success"><i class="fa-solid fa-pen"></i></button> ';
                    break;
            }
            $dado = array();
            $dado[] = "#" . $delivery->id;
            $dado[] = $delivery->payment->name;
            $dado[] = date('d/m/y', strtotime($delivery->updated_at)) . " as " . date('h:i', strtotime($delivery->updated_at));
            $dado[] = $delivery->address->street_address . ', Nº' . $delivery->address->number . ', ' . $delivery->address->neighborhood;
            $dado[] = Calculate::requestValue($delivery->id, [1, 4], true, true);
            $dado[] = $buttons;
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
}
