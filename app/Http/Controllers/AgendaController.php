<?php

namespace App\Http\Controllers;

use App\Models\AgendaModel;
use App\Models\AppSettingsModel;
use App\Models\RequestsItemsModel;
use App\Models\TypeItemModel;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public static function show_banner()
    {
        $agenda = AgendaModel::latest()->take(5)->get();
        if (count($agenda) > 0) {
            return $agenda;
        } else {
            $app_settings = AppSettingsModel::first();
            $content = [];
            foreach (TypeItemModel::latest()->take(5)->get() as $type_item) {
                $content[] = [
                    'title' => $type_item->name,
                    'description' => $type_item->description ? $type_item->description : 'Acesse o cardápio no botão abaixo',
                    'url_banner' => 'img/gourmetconnect-logo/background-login.png',
                    'url_img2' => $app_settings->logo_url,
                    'url_img1' => $type_item->photo_url,
                ];
            }
            return $content;

        }
    }

    public static function more_requests()
    {
        $items_request = RequestsItemsModel::select('updated_at', DB::raw('COUNT(id) as product_id'))
            ->whereMonth('updated_at', date('m'))
            ->where('status', 4)
            ->groupBy('updated_at')
            ->get();

    }
}
