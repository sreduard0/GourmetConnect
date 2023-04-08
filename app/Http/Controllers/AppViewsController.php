<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AppSettingsModel;
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
        return view('app.delivery');
    }
    public function tables()
    {
        $data = [
            'app_settings' => AppSettingsModel::select('number_tables')->first(),
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
