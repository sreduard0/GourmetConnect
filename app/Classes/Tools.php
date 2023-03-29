<?php

namespace App\Classes;

use App\Models\RequestsItemsModel;

class Tools
{
    // SOMA O VALOR DE TODOS PRODUTOS
    public function sum_values_requests($id)
    {
        $itemsRequest = RequestsItemsModel::with('additionals')
            ->select('id', 'value')
            ->where('request_id', $id)
            ->where('status', '>', 1)
            ->get();

        $sum = [];
        foreach ($itemsRequest as $item) {
            $sum[] = $item->value;
            foreach ($item->additionals as $additional) {
                $sum[] = $additional->value;
            }

        }

        return 'R$' . number_format(array_sum($sum), 2, ',', '.');
    }
    // SOMA O VALOR DE UM UNICO ITEM
    public function sum_values_item($id)
    {
        $itemsRequest = RequestsItemsModel::with('additionals')
            ->select('id', 'value')
            ->where('id', $id)
            ->first();

        $sum[] = $itemsRequest->value;
        foreach ($itemsRequest->additionals as $item) {
            $sum[] = $item->value;
        }
        return 'R$' . number_format(array_sum($sum), 2, ',', '.');
    }
    // SOMA O VALOR DE UM UNICO ITEM
    public function sum_values_items_equals($item, $request)
    {
        $items = RequestsItemsModel::with('additionals')
            ->select('id', 'value')
            ->where('request_id', $request)
            ->where('product_id', $item)
            ->where('status', '>', 1)
            ->get();

        $sum = [];
        foreach ($items as $item) {
            $sum[] = $item->value;
            foreach ($item->additionals as $additional) {
                $sum[] = $additional->value;
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
