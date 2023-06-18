<?php

namespace App\Http\Controllers;

use App\Classes\Calculate;
use App\Classes\Tools;
use App\Models\AdditionalItemModel;
use App\Models\DeliveryAddressModel;
use App\Models\DeliveryLocationsModel;
use App\Models\ItemModel;
use App\Models\RequestAdditionalItemModal;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use App\Models\UsersClientModel;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //-----------------------------------------
    // CRUD VENDA DE ITENS
    //-----------------------------------------
    // CRIANDO PEDIDO
    public function create(Request $request)
    {
        $data = $request->all();
        try {
            $delivery_order = RequestsModel::select('id')->where('client_id', auth()->guard('client')->id())->where('status', false)->where('delivery', 1)->first();
            if (!$delivery_order) {
                $delivery_order = new RequestsModel();
                $delivery_order->delivery = 1;
                $delivery_order->client_name = strtoupper(session('user')['name']);
                $delivery_order->client_id = auth()->guard('client')->id();
                $delivery_order->status = 0;
                $delivery_order->save();
            }

            $product = ItemModel::select('value')->find(Tools::hash(session('item_selected'), 'decrypt'));
            for ($i = 1; $i <= $data['qty']; $i++) {
                $item = new RequestsItemsModel;
                $item->request_id = $delivery_order->id;
                $item->product_id = Tools::hash(session('item_selected'), 'decrypt');
                $item->status = 1;
                $item->value = $product->value;
                $item->waiter = 'Site';
                $item->observation = $data['obs'];
                if ($item->save() && isset($data['additionals'])) {
                    foreach ($data['additionals'] as $input) {
                        if ($input['check'] == 'true') {
                            $additional = AdditionalItemModel::select('value')->find($input['id']);
                            $additionals = [
                                'additional_id' => $input['id'],
                                'item_id' => $item->id,
                                'value' => $additional->value,
                            ];
                            RequestAdditionalItemModal::create($additionals);
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            return ['error' => true, 'message' => 'Ouve um erro ao adicionar este item no seu pedido, tente novamente.'];
        }
        return ['error' => false, 'message' => 'Adicionado(s)'];
    }
    // APRESENTANDO ITEM
    public function show($id)
    {
        return ItemModel::with('like')->find(Tools::hash($id, 'decrypt'));
    }

    // PREENCHE FORM DE EDIÇÂO
    public function edit(string $id)
    {
        $item = RequestsItemsModel::find(Tools::hash($id, 'decrypt'));
        $itemsCheck = RequestAdditionalItemModal::where('item_id', $item->id)->get();
        $items = AdditionalItemModel::where('item_id', $item->product_id)->get();

        $additionalItems['observation'] = $item->observation;
        $additionalItems['items'] = [];
        foreach ($items as $item) {
            if ($item->status == 1) {
                $additionalItems['items'][$item->id] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'value' => $item->value,
                    'check' => '',
                ];
            }
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

    // SALVA EDIÇÃO ITEM DO PEDIDO
    public function update(Request $request)
    {
        try {
            $inputs = $request->all();
            if (isset($inputs['additionals'])) {
                foreach ($inputs['additionals'] as $input) {
                    if ($input['check'] == 'true') {
                        $additional = AdditionalItemModel::select('value')->find($input['id']);
                        $additionals = [
                            'additional_id' => $input['id'],
                            'item_id' => Tools::hash($inputs['id'], 'decrypt'),
                            'value' => $additional->value,
                        ];
                        RequestAdditionalItemModal::updateOrCreate(['additional_id' => $input['id'], 'item_id' => Tools::hash($inputs['id'], 'decrypt')], $additionals);
                    } else {
                        RequestAdditionalItemModal::where('additional_id', $input['id'])->where('item_id', Tools::hash($inputs['id'], 'decrypt'))->delete();
                    }
                }
            }
            $observation = RequestsItemsModel::find(Tools::hash($inputs['id'], 'decrypt'));
            $observation->observation = $inputs['obs'];
            $observation->value = Calculate::itemValue(Tools::hash($inputs['id'], 'decrypt'));
            $observation->save();
            return ['error' => false, 'message' => 'Salvo!'];
        } catch (\Throwable $th) {
            return ['error' => true, 'message' => 'Ouve um erro ao salvar .'];

        }
    }

    // DELETA ITEM DO CARRINHO
    public function delete($id)
    {
        if (RequestsItemsModel::find(Tools::hash($id, 'decrypt'))->delete() && RequestAdditionalItemModal::where('item_id', Tools::hash($id, 'decrypt'))->delete()) {
            return ['error' => false, 'message' => 'Item excluido.'];
        } else {
            return ['error' => true, 'message' => 'Ouve um erro ao excluir.'];
        }
    }

    // LIMPA CARRINHO
    public function clear_cart()
    {
        try {
            $delivery_order = RequestsModel::select('id')->where('client_id', auth()->guard('client')->id())->where('status', 0)->where('delivery', 1)->first();
            if ($delivery_order) {
                $items = RequestsItemsModel::where('request_id', $delivery_order->id)->where('status', 1)->get();
                foreach ($items as $item) {
                    RequestsItemsModel::find($item->id)->delete();
                    RequestAdditionalItemModal::where('item_id', $item->id)->delete();
                }
                return ['error' => false, 'message' => 'Seu carrinho agora esta limpo.'];
            } else {
                return ['error' => true, 'message' => 'Não há pedidos para limpar.'];
            }
        } catch (\Throwable $th) {
            return ['error' => true, 'message' => 'Ouve algum erro ao limpar o carrinho.'];
        }
    }

    // ENVIAR CARRINHO
    public function send_cart(Request $request)
    {
        $requestData = $request->all();
        try {
            $delivery_order = RequestsModel::where('client_id', auth()->guard('client')->id())->where('status', 0)->where('delivery', 1)->first();
            if ($delivery_order && RequestsItemsModel::where('request_id', $delivery_order->id)->where('status', 1)->count() > 0) {
                RequestsItemsModel::where('request_id', $delivery_order->id)->where('status', 1)->update(['status' => 2]);
                $delivery_order->status = 1;
                $delivery_order->payment_method = $requestData['payment'];
                $delivery_order->save();
                if (isset($requestData['address'])) {
                    $delivery_location = DeliveryLocationsModel::find($requestData['address']['location']);
                    $delivery_address = new DeliveryAddressModel();
                    $delivery_address->request_id = $delivery_order->id;
                    $delivery_address->location_id = $requestData['address']['location'];
                    $delivery_address->recipient_name = strtoupper(session('user')['name']);
                    $delivery_address->street_address = $requestData['address']['street'];
                    $delivery_address->neighborhood = $requestData['address']['neighborhood'];
                    $delivery_address->phone = str_replace(['(', ')', '-', ' '], '', $requestData['address']['phone']);
                    $delivery_address->reference = $requestData['address']['reference'];
                    $delivery_address->number = str_replace('_', '', $requestData['address']['number']);
                    $delivery_address->delivery_value = $delivery_location->value_delivery;
                    $delivery_address->save();
                } else {
                    $user_address = UsersClientModel::with('location')->where('login_id', auth()->guard('client')->id())->first();
                    $delivery_address = new DeliveryAddressModel();
                    $delivery_address->request_id = $delivery_order->id;
                    $delivery_address->location_id = $user_address->location_id;
                    $delivery_address->recipient_name = strtoupper(session('user')['name']);
                    $delivery_address->street_address = $user_address->street_address;
                    $delivery_address->neighborhood = $user_address->neighborhood;
                    $delivery_address->phone = $user_address->phone;
                    $delivery_address->reference = $user_address->reference;
                    $delivery_address->number = $user_address->number;
                    $delivery_address->delivery_value = $user_address->location->value_delivery;
                    $delivery_address->save();

                }
                return ['error' => false, 'message' => 'Pedido enviado.'];
            } else {
                return ['error' => true, 'message' => 'Carrinho está vázio.'];
            }
        } catch (\Throwable $th) {
            return ['error' => true, 'message' => 'Ouve algum erro ao enviar pedido.'];
        }
    }
}
