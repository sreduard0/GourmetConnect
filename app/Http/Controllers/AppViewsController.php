<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AppSettingsModel;
use App\Models\DeliveryLocationsModel;
use App\Models\ItemModel;
use App\Models\PaymentMethodsModel;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use App\Models\TypeItemModel;

class AppViewsController extends Controller
{
    // FERRAMENTAS
    private $Tools;
    public function __construct()
    {
        $this->Tools = new Tools;
    }
    public function control_panel()
    {
        return view('app.control-panel');
    }
    public function requests()
    {
        $data = [
            'app_settings' => AppSettingsModel::select('number_tables')->first(),
            'types' => TypeItemModel::all(),
        ];

        return view('app.requests', $data);
    }
    public function close_request($id)
    {
        if (RequestsModel::where('id', $this->Tools->hash($id, 'decrypt'))->where('status', 1)->first()) {

            $data = [
                'app_settings' => AppSettingsModel::all()->first(),
                'command' => RequestsModel::find($this->Tools->hash($id, 'decrypt')),
                'payment_methods' => PaymentMethodsModel::where('active', 1)->get(),
                'finalize' => RequestsItemsModel::select('status')->where('request_id', $this->Tools->hash($id, 'decrypt'))->where('status', 3)->first(),
            ];

            return view('app.close-request', $data);
        } else {
            return back();
        }
    }
    public function delivery()
    {
        $data = [
            'types' => TypeItemModel::all(),
            'locations' => DeliveryLocationsModel::all(),
            'payment_methods' => PaymentMethodsModel::where('active', 1)->get(),
        ];
        return view('app.delivery', $data);
    }
    public function tables()
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
                    $table['value'] = $this->Tools->sum_values_table($i);
                    $table['request'] = $waiter->waiter;
                }
                $table['pendent'] = RequestsItemsModel::select('status')->whereIn('request_id', $id)->where('status', 2)->exists();
            } else {
                $table['client'] = 'Vazia';
                $table['value'] = '-';
                $table['request'] = '-';
                $table['pendent'] = false;

            }
            $table['qr_value'] = $this->Tools->hash($i, 'encrypt');
            $tables[$i] = $table;
        }

        $data = [
            'types' => TypeItemModel::all(),
            'app_settings' => AppSettingsModel::select('number_tables')->first(),
            'tables' => $tables,
        ];
        return view('app.tables', $data);
    }
    public function menu()
    {
        $data = [
            'types' => TypeItemModel::all(),
            'items' => ItemModel::all(),
        ];
        return view('app.menu', $data);
    }
    public function users()
    {
        return view('app.users');
    }
    public function app_settings()
    {
        $data = [
            'app_settings' => AppSettingsModel::all()->first(),
            'payment_methods' => PaymentMethodsModel::all(),
        ];

        return view('app.app-settings', $data);
    }
    public function site_settings()
    {

        return view('app.site-settings');
    }
}
