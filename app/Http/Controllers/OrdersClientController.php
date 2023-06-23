<?php

namespace App\Http\Controllers;

use App\Classes\Calculate;
use App\Classes\Tools;
use App\Models\DeliveryAddressModel;
use App\Models\RequestsModel;
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
    public static function update($data)
    {

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
}
