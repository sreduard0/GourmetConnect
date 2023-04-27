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
use Spatie\Permission\Models\Permission;

class AppViewsController extends Controller
{
    public function form_login()
    {
        $data = [
            'app_settings' => AppSettingsModel::first(),
        ];
        return view('app.login.form-login', $data);
    }
    public function control_panel()
    {
        $data = [
            'delivery_qty' => RequestsModel::where('delivery', 1)->where('status', 4)->count(),
            'sales_item_type' => ControlPanelController::sales_item_type(),
            'total_sales' => ControlPanelController::month_and_year_sales(),
            'newly_added_items' => ItemModel::latest()->take(4)->get(),
        ];
        return view('app.control-panel', $data);
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
        if (RequestsModel::where('id', Tools::hash($id, 'decrypt'))->where('status', 1)->first()) {
            $data = [
                'app_settings' => AppSettingsModel::all()->first(),
                'command' => RequestsModel::find(Tools::hash($id, 'decrypt')),
                'payment_methods' => PaymentMethodsModel::where('active', 1)->get(),
                'finalize' => RequestsItemsModel::select('status')->where('request_id', Tools::hash($id, 'decrypt'))->where('status', 3)->first(),
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
        $data = [
            'types' => TypeItemModel::all(),
            'app_settings' => AppSettingsModel::select('number_tables')->first(),
            'tables' => TablesController::tables(),
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
        $data = [
            'permissions' => Permission::all(),
        ];
        return view('app.users', $data);
    }
    public function app_settings()
    {
        $data = [
            'app_settings' => AppSettingsModel::first(),
            'payment_methods' => PaymentMethodsModel::all(),
        ];

        return view('app.app-settings', $data);
    }
    public function site_settings()
    {
        return view('app.site-settings');
    }
}
