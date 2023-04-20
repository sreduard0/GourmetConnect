<?php

namespace App\Http\Controllers;

use App\Classes\Calculate;
use App\Classes\Tools;
use App\Models\DeliveryAddressModel;
use App\Models\ItemModel;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use App\Models\TypeItemModel;
use Illuminate\Support\Facades\DB;

class ControlPanelController extends Controller
{
    public function monthly_sales_chart()
    {
        $items_menu = ItemModel::select('id', 'name')->get();
        foreach ($items_menu as $item) {
            $color = Tools::colorGenerate($item->id);
            $months = [];
            $items_request = RequestsItemsModel::select('updated_at', DB::raw('COUNT(id) as product_id'))
                ->whereYear('updated_at', date('Y'))
                ->where('product_id', $item->id)
                ->where('status', 4)
                ->groupBy('updated_at')
                ->get()->toArray();

            for ($i = 0; $i <= date('n') - 1; $i++) {
                $months[$i] = 0;
            }

            foreach ($items_request as $item_request) {
                $months[date('n', strtotime($item_request['updated_at'])) - 1] += $item_request['product_id'];
            }

            $statistics[] = [
                'type' => 'line',
                'data' => $months,
                'backgroundColor' => 'transparent',
                'borderColor' => $color,
                'pointBorderColor' => $color,
                'pointBackgroundColor' => $color,
                'fill' => false,
                'label' => $item->name,
            ];
        }

        return $statistics;

    }
    public function areas_with_more_delivery()
    {
        $deliverys = DeliveryAddressModel::with('location')->select('location_id', DB::raw('COUNT(id) as count'))
            ->whereMonth('created_at', date('m'))
            ->where('delivered', 1)
            ->groupBy('location_id')
            ->get()->toArray();

        foreach ($deliverys as $location) {
            $statistics['labels'][] = $location['location']['neighborhood'] . ' - ' . $location['location']['reference'];
            $statistics['colors'][] = Tools::colorGenerate($location['location']['neighborhood']);
            $statistics['data'][] = $location['count'];
        }
        return $statistics;
    }
    public static function sales_item_type()
    {
        $type_items = TypeItemModel::all();

        $total_sales = RequestsItemsModel::whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->where('status', 4)->count();
        foreach ($type_items as $type_item) {
            $color = Tools::colorGenerate($type_item->name);
            $ids_items = ItemModel::select('id')->where('type_id', $type_item->id)->get();
            $qty_type = RequestsItemsModel::whereIn('product_id', $ids_items)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->where('status', 4)->count();
            $statistics[] = [
                'type_item' => $type_item->name,
                'color' => $color,
                'percentage' => Calculate::percentage($qty_type, $total_sales),
                'total' => $qty_type,
            ];
        }
        $data = [
            'statistics' => $statistics,
            'total_sales' => $total_sales,
        ];
        return $data;
    }
    public static function month_and_year_sales()
    {
        $months = [
            1 => 'DEZ <i class="fa-solid fa-caret-right"></i> JAN',
            2 => 'JAN <i class="fa-solid fa-caret-right"></i> FEV',
            3 => 'FEV <i class="fa-solid fa-caret-right"></i> MAR',
            4 => 'MAR <i class="fa-solid fa-caret-right"></i> ABR',
            5 => 'ABR <i class="fa-solid fa-caret-right"></i> MAI',
            6 => 'MAI <i class="fa-solid fa-caret-right"></i> JUN',
            7 => 'JUN <i class="fa-solid fa-caret-right"></i> JUL',
            8 => 'JUL <i class="fa-solid fa-caret-right"></i> AGO',
            9 => 'AGO <i class="fa-solid fa-caret-right"></i> SET',
            10 => 'SET <i class="fa-solid fa-caret-right"></i> OUT',
            11 => 'OUT <i class="fa-solid fa-caret-right"></i> NOV',
            12 => 'NOV <i class="fa-solid fa-caret-right"></i> DEZ',
        ];
        $delivery = RequestsModel::select('id')->where('delivery', 1)->where('status', 4)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->get()->toArray();
        $local = RequestsModel::select('id')->where('delivery', 0)->where('status', 2)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->get()->toArray();

        $delivery_old = RequestsModel::select('id')->where('delivery', 1)->where('status', 4)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m', strtotime('-1 month')))->get()->toArray();
        $local_old = RequestsModel::select('id')->where('delivery', 0)->where('status', 2)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m', strtotime('-1 month')))->get()->toArray();

        $total_year_delivery = RequestsModel::select('id')->where('delivery', 1)->where('status', 4)->whereYear('updated_at', date('Y'))->get()->toArray();
        $total_year_local = RequestsModel::select('id')->where('delivery', 0)->where('status', 2)->whereYear('updated_at', date('Y'))->get()->toArray();

        $total_old_year_delivery = RequestsModel::select('id')->where('delivery', 1)->where('status', 4)->whereYear('updated_at', date('Y') - 1)->get()->toArray();
        $total_old_year_local = RequestsModel::select('id')->where('delivery', 0)->where('status', 2)->whereYear('updated_at', date('Y') - 1)->get()->toArray();

        $statistics['local'] = [
            'months' => $months[(int) date('m')],
            'percentage' => Calculate::percentage(Calculate::requestValue($local_old, 4), Calculate::requestValue($local, 4), true),
            'value' => Calculate::requestValue($local, 4, false, false),
        ];
        $statistics['delivery'] = [
            'months' => $months[(int) date('m')],
            'percentage' => Calculate::percentage(Calculate::requestValue($delivery_old, 4), Calculate::requestValue($delivery, 4), true),
            'value' => Calculate::requestValue($delivery, 4, false, true),
        ];
        $statistics['total_year_delivery'] = [
            'percentage' => Calculate::percentage(Calculate::requestValue($total_old_year_delivery, 4), Calculate::requestValue($total_year_delivery, 4), true),
            'value' => Calculate::requestValue($total_year_delivery, 4, false, true),
        ];
        $statistics['total_year_local'] = [
            'percentage' => Calculate::percentage(Calculate::requestValue($total_old_year_local, 4), Calculate::requestValue($total_year_delivery, 4), true),
            'value' => Calculate::requestValue($total_year_local, 4, false, true),
        ];
        return $statistics;

    }

}
