<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AdditionalItemModel;
use App\Models\ItemModel;

class ItemsSalesController extends Controller
{
    // APRESENTANDO ITEM
    public function show($id)
    {
        return ItemModel::with('like')->find(Tools::hash($id, 'decrypt'));
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
}
