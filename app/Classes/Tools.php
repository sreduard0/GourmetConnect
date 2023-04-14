<?php

namespace App\Classes;

use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;

class Tools
{
    // SOMA O VALOR DE TODOS PRODUTOS
    public function sum_values_requests($id, $delivery = 0)
    {
        $itemsRequest = RequestsItemsModel::with('additionals', 'product')
            ->where('request_id', $id)
            ->whereBetween('status', [1, 3])
            ->get();

        if (count($itemsRequest) > 0) {
            $sum['delivery'] = $delivery;
        } else {
            $sum = [];
        }
        foreach ($itemsRequest as $item) {
            $sum[] = $item->product->value;
            foreach ($item->additionals as $additional) {
                $sum[] = $additional->value;
            }

        }

        return 'R$' . number_format(array_sum($sum), 2, ',', '.');
    }
    // SOMA O VALOR DE UM UNICO ITEM
    public function sum_values_item($id)
    {
        $itemsRequest = RequestsItemsModel::with('additionals', 'product')
            ->where('id', $id)
            ->first();

        $sum[] = $itemsRequest->product->value;
        foreach ($itemsRequest->additionals as $item) {
            $sum[] = $item->value;
        }
        return 'R$' . number_format(array_sum($sum), 2, ',', '.');
    }
    // SOMA O VALOR DE  ITEM IGUAIS
    public function sum_values_items_equals($item, $request)
    {
        $items = RequestsItemsModel::with('additionals', 'product')
            ->where('request_id', $request)
            ->where('product_id', $item)
            ->whereBetween('status', [1, 3])
            ->get();

        $sum = [];
        foreach ($items as $item) {
            $sum[] = $item->product->value;
            foreach ($item->additionals as $additional) {
                $sum[] = $additional->value;
            }

        }

        return 'R$' . number_format(array_sum($sum), 2, ',', '.');

    }
    // SOMA O VALOR DE TOTAL DA MESA
    public function sum_values_table($table)
    {
        $requests = RequestsModel::where('table', $table)->where('delivery', 0)->where('status', 1)->get();
        $sum = [];

        foreach ($requests as $request) {
            $itemsRequest = RequestsItemsModel::with('additionals', 'product')
                ->where('request_id', $request->id)
                ->whereBetween('status', [1, 3])
                ->get();
            foreach ($itemsRequest as $item) {
                $sum[] = $item->product->value;
                foreach ($item->additionals as $additional) {
                    $sum[] = $additional->value;
                }
            }
        }

        return 'R$' . number_format(array_sum($sum), 2, ',', '.');
    }
    // CRIPTOGRAFA VALORES
    public function hash($value, $function)
    {
        switch ($function) {
            case 'encrypt':
                return bin2hex(openssl_encrypt($value, 'aes-256-cbc', 'nooo?|3Td+u#B7U{9q{fyP>BV*ayB=)y', OPENSSL_RAW_DATA, '">D;0qamld5]B)_z'));
                break;
            case 'decrypt':
                return openssl_decrypt(hex2bin($value), 'aes-256-cbc', 'nooo?|3Td+u#B7U{9q{fyP>BV*ayB=)y', OPENSSL_RAW_DATA, '">D;0qamld5]B)_z');
                break;
        }
    }
    public function sum_values_item_number($id)
    {
        $itemsRequest = RequestsItemsModel::with('additionals', 'product')
            ->where('id', $id)
            ->first();

        $sum[] = $itemsRequest->product->value;
        foreach ($itemsRequest->additionals as $item) {
            $sum[] = $item->value;
        }
        return array_sum($sum);
    }
    //====================[Mascara para strings]===========================
    public function mask($mask, $str)
    {
        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }
        return $mask;
    }
}
