<?php

namespace App\Http\Controllers;

use App\Models\AppSettingsModel;
use App\Models\ItemModel;
use App\Models\TypeItemModel;

class AppViewsController extends Controller
{
    public function control_panel()
    {
        return view('app.control-panel');
    }
    public function requests()
    {
        $data = [
            'app_settings' => AppSettingsModel::select('number_tables')->first(),
        ];

        return view('app.requests', $data);
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
        ];

        return view('app.app-settings', $data);
    }
    public function site_settings()
    {

        return view('app.site-settings');
    }
}
