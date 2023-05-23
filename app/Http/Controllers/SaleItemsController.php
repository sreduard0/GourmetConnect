<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AdditionalItemModel;
use App\Models\ItemModel;
use App\Models\RequestAdditionalItemModal;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use Illuminate\Http\Request;

class SaleItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->all();
        try {
            $delivery_order = RequestsModel::select('id')->where('client_id', auth()->guard('client')->id())->where('status', '<=', 3)->where('delivery', 1)->first();
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return ItemModel::with('like')->find(Tools::hash($id, 'decrypt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // LISTAR ADICIONAIS
    public function additionals($id)
    {
        session()->put('item_selected', $id);
        $additionals = AdditionalItemModel::where('item_id', Tools::hash($id, 'decrypt'))->get();
        $additionalItems['items'] = [];
        foreach ($additionals as $item) {
            if ($item->status == 1) {
                $additionalItems['items'][$item->id] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'value' => $item->value,
                    'check' => '',
                ];
            }
        }
        return $additionalItems;
    }

    // CONTAGEM DE ITENS NO CARRINHO
    public function cart_count()
    {
        $order = RequestsModel::where('client_id', auth()->guard('client')->id())->where('status', '<=', 3)->where('delivery', 1)->first();
        if ($order) {
            return RequestsItemsModel::where('request_id', $order->id)->where('status', 1)->count();
        } else {
            return false;
        }
    }

}
