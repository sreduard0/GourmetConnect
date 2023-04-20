<?php

namespace App\Http\Controllers;

use App\Classes\Calculate;
use App\Classes\Tools;
use App\Models\AppSettingsModel;
use App\Models\NotificationModel;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TablesController extends Controller
{
    // INFORMAÇÃO DE TODAS MESAS
    public static function tables()
    {
        $app_settings = AppSettingsModel::select('number_tables')->first();
        $tables = [];
        for ($i = 1; $i <= $app_settings->number_tables; ++$i) {
            $table = [];
            $requests = RequestsModel::where('table', $i)->where('delivery', 0)->where('status', 1)->get();
            $table['table'] = $i;
            $id = [];
            if (count($requests) > 0) {
                foreach ($requests as $request) {
                    $waiter = RequestsItemsModel::select('waiter')->where('request_id', $request->id)->orderBy('id', 'desc')->first();
                    if (!isset($table['client'])) {
                        $table['client'] = $request->client_name;
                        $id[] = $request->id;
                    } else {
                        $table['client'] = $table['client'] . ', ' . $request->client_name;
                        $id[] = $request->id;
                    }
                    $table['value'] = Calculate::tableValue($i, true, [2, 3]);
                    $table['request'] = $waiter->waiter;
                }
                $table['pendent'] = RequestsItemsModel::select('status')->whereIn('request_id', $id)->where('status', 2)->exists();
            } else {
                $table['client'] = 'Vazia';
                $table['value'] = '-';
                $table['request'] = '-';
                $table['pendent'] = false;

            }
            $table['qr_value'] = Tools::hash($i, 'encrypt');
            $tables[$i] = $table;
        }
        return $tables;
    }

    // RECARREGA INFORMAÇÕES DAS MESAS
    public function tables_events()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $new_event = NotificationModel::orderBy('created_at', 'desc')->first();
        $tables = '';
        if ($new_event && session('event_id') != $new_event->id) {
            $tables = TablesController::tables();
            session()->put(['event_id' => $new_event->id]);
        }
        $response->setContent('data: ' . json_encode($tables) . "\n\n");
        $response->send();

    }

    // INFORMAÇÃO DE UMA MESA ESPECIFICA
    public function table_info(Request $request)
    {
        $data = [];
        foreach (RequestsModel::where('table', $request->get('table'))->where('status', 1)->where('delivery', 0)->get() as $table) {
            $ico = '';
            if (RequestsItemsModel::select('status')->where('request_id', $table->id)->where('status', 2)->exists()) {
                $ico = ' (Há pedido)';
            }
            $data[] = [
                'text' => $table->client_name . $ico,
                'value' => Tools::hash($table->id, 'encrypt'),
            ];
        }
        return $data;
    }
}
