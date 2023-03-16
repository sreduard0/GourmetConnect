<?php

namespace App\Http\Controllers;

use App\Models\AppSettingsModel;
use Illuminate\Http\Request;

class AppSettingsController extends Controller
{
    public function save_establishment_settings(Request $request)
    {
        $data = $request->all();
        $save_data = AppSettingsModel::all()->first();
        $save_data->establishment_name = $data['establishment_name'];
        $save_data->cnpj = str_replace(['/', '.', '-', '_'], '', $data['establishment_cnpj']);
        $save_data->address = $data['establishment_address'];
        $save_data->number = str_replace(['/', '.', '-', '_'], '', $data['establishment_number']);
        $save_data->neighborhood = $data['establishment_neighborhood'];
        $save_data->city = $data['establishment_city'];
        $save_data->state = $data['establishment_state'];
        $save_data->save();
        return 'success';

    }
    public function save_theme_settings(Request $request)
    {
        $data = $request->all();

        $save_data = AppSettingsModel::all()->first();
        $save_data->theme_background = $data['theme_background'];
        $save_data->theme_accent = $data['theme_accent'];
        $save_data->theme_sidebar = $data['theme_sidebar'];
        $save_data->save();
        return 'success';

    }
    public function save_general_settings(Request $request)
    {
        $data = $request->all();
        $save_data = AppSettingsModel::all()->first();
        $save_data->number_tables = str_replace(['/', '.', '-', '_'], '', $data['general_tables']);
        $save_data->save();
        return 'success';
    }
    public function installation()
    {
        if (!AppSettingsModel::all()->first()) {
            $save_data = new AppSettingsModel();
            // $save_data->logo_url = 'img\gourmetconnect-logo\gourmetconnect.png';
            $save_data->establishment_name = 'GourmetConnect';
            $save_data->cnpj = 888888888;
            $save_data->address = 'rua xxx';
            $save_data->number = 000;
            $save_data->neighborhood = 'xxx';
            $save_data->city = 'nsr';
            $save_data->state = 'rs';
            $save_data->theme_background = 'dark-mode';
            $save_data->theme_accent = 'accent-danger';
            $save_data->theme_sidebar = 'sidebar-dark-danger';

            $save_data->save();
            return 'success';
        }
    }
}
