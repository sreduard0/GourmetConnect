<?php

namespace App\Classes;

use App\Models\DeliveryAddressModel;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;

class Calculate
{
// -------------------------------
// SOMA VALORES
// -------------------------------
    // SOMA O VALOR DE PRODUTOS
    public static function requestValue(mixed $id, mixed $status, bool $delivery_value = false, bool $formated = false)
    {
        if (!is_array($id)) {
            $id = array($id);
        }

        $sum[] = 0.00;
        $query = RequestsItemsModel::with('additionals', 'product')
            ->whereIn('request_id', $id);
        if (is_array($status)) {
            $query->whereBetween('status', $status);
        } else {
            $query->where('status', $status);
        }
        $items = $query->get();

        if ($delivery_value) {
            $delivery_address = DeliveryAddressModel::select('delivery_value')->whereIn('request_id', $id)->get();
            if (count($items) > 0) {
                foreach ($delivery_address as $delivery) {
                    $sum[] = $delivery->delivery_value;
                }
            }

        }
        foreach ($items as $item) {
            $sum[] = $item->product->value;
            foreach ($item->additionals as $additional) {
                $sum[] = $additional->value;
            }

        }
        if ($formated) {
            return 'R$' . number_format(array_sum($sum), 2, ',', '.');
        } else {
            return array_sum($sum);
        }
    }
    // SOMA VALORES DE UM ITEM
    public static function itemValue($id, $formated = false)
    {
        $item = RequestsItemsModel::with('additionals', 'product')->find($id);
        $sum = [];

        $sum[] = $item->product->value;
        foreach ($item->additionals as $additional) {
            $sum[] = $additional->value;
        }

        if ($formated) {
            return 'R$' . number_format(array_sum($sum), 2, ',', '.');
        } else {
            return array_sum($sum);
        }

    }

    // SOMA VALOR DE ITEM IGUAIS DE UM PEDIDO
    public static function itemEqualsValue($item, $request, $status = [1, 3], $formated = false)
    {
        if (!is_array($status)) {
            $status = array($status);
        }

        $items = RequestsItemsModel::with('additionals', 'product')
            ->where('request_id', $request)
            ->where('product_id', $item)
            ->whereIn('status', $status)
            ->get();

        $sum = [];
        foreach ($items as $item) {
            $sum[] = $item->product->value;
            foreach ($item->additionals as $additional) {
                $sum[] = $additional->value;
            }
        }

        if ($formated) {
            return 'R$' . number_format(array_sum($sum), 2, ',', '.');
        } else {
            return array_sum($sum);
        }

    }

    // SOMA O VALOR DE TOTAL DA MESA
    public static function tableValue($table, $formated = false, $status = [1, 2, 3])
    {
        $requests = RequestsModel::where('table', $table)->where('delivery', 0)->where('status', 1)->get();
        $sum = [];
        foreach ($requests as $request) {
            $itemsRequest = RequestsItemsModel::with('additionals', 'product')
                ->where('request_id', $request->id)
                ->whereIn('status', $status)
                ->get();
            foreach ($itemsRequest as $item) {
                $sum[] = $item->product->value;
                foreach ($item->additionals as $additional) {
                    $sum[] = $additional->value;
                }
            }
        }

        if ($formated) {
            return 'R$' . number_format(array_sum($sum), 2, ',', '.');
        } else {
            return array_sum($sum);
        }

    }

// -------------------------------
// OUTROS CALCULOS
// -------------------------------
    // PORCENTAGEM
    public static function percentage($value1, $value2, $value_difference = false, $simbol = false)
    {
        if ($value_difference) {
            $difference = $value2 - $value1;
            if ($value1 == 0 || $difference == 0) {
                $percentage = 0;
            } else {
                $percentage = ($difference / $value1) * 100;
            }

        } else {
            if ($value1 == 0 || $value2 == 0) {
                $percentage = 0;
            } else {
                $percentage = ($value1 / $value2) * 100;
            }
        }

        if ($simbol) {
            return number_format($percentage, 2) . '%';
        } else {
            return number_format($percentage, 2);
        }
    }
    public static function discountPercentage($old_value, $current_value, $simbol = false)
    {

        if ($old_value == 0 || $current_value == 0) {
            $percentage = 0;
        } else {
            $percentage = ((($old_value - $current_value) / $old_value) * 100);
        }

        if ($simbol) {
            return round($percentage) . '%';
        } else {
            return round($percentage);
        }
    }
}
