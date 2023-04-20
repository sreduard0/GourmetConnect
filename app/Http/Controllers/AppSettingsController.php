<?php

namespace App\Http\Controllers;

use App\Models\AppSettingsModel;
use App\Models\DeliveryLocationsModel;
use App\Models\PaymentMethodsModel;
use Illuminate\Http\Request;

class AppSettingsController extends Controller
{
    //--------------------------------
    // ESTABELECIMENTO
    //--------------------------------
    // EDITA AS CONFIGURAÇÕES
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
        $save_data->cep = str_replace(['.', '-', '_'], '', $data['establishment_cep']);
        $save_data->save();
        if ($data['general_tables']) {
            $save_data = AppSettingsModel::all()->first();
            $save_data->number_tables = str_replace(['/', '.', '-', '_'], '', $data['general_tables']);
            $save_data->save();
        }
        if ($data['methods']) {
            PaymentMethodsModel::select('active')->update(['active' => 0]);
            PaymentMethodsModel::whereIn('id', $data['methods'])->update(['active' => 1]);
        }

        return 'success';
    }
    // EXIBE
    public function logo()
    {
        $app = AppSettingsModel::all()->first();
        return $app->logo_url;
    }

    //--------------------------------
    // APP TEMA
    //--------------------------------
    // SALVA CONFIGURAÇÕES DE TEMA
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

    //--------------------------------
    // ESTABELECIMENTO
    //--------------------------------
    public function save_delivery_local_settings(Request $request)
    {
        $data = $request->all();
        $location = new DeliveryLocationsModel();
        $location->neighborhood = strtoupper($data['delivery_neighborhood']);
        $location->reference = $data['delivery_reference'];
        $location->value_delivery = str_replace(',', '.', str_replace('.', '', $data['delivery_value']));
        if ($location->save()) {
            return 'success';
        }
    }
    // DELETAR
    public function delete_delivery_local(Request $request)
    {
        if (DeliveryLocationsModel::find($request->get('id'))->delete()) {
            return 'success';
        }
    }

    public function delivery_locations(Request $request)
    {
        $locationData = $request->all();
        $columns = array(
            0 => 'neighborhood',
            1 => 'reference',
            2 => 'value',
            3 => 'id',
        );

        $locations = DeliveryLocationsModel::orderBy($columns[$locationData['order'][0]['column']], $locationData['order'][0]['dir'])
            ->offset($locationData['start'])
            ->take($locationData['length'])
            ->get();
        $rows = DeliveryLocationsModel::all()->count();

        $filtered = count($locations);
        $dados = array();
        foreach ($locations as $location) {
            $dado = array();
            $dado[] = $location->neighborhood;
            $dado[] = $location->reference;
            $dado[] = 'R$' . number_format($location->value_delivery, 2, ',', '.');
            $dado[] = '<button onclick="return delete_local(' . $location->id . ')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($locationData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows),
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json

    }

    // ---------------------------
    // INTALAÇÃO DO SISTEMA
    // ---------------------------
    public function installation()
    {
        // EXECUTAR MIGRATES
        // CONFIGURAÇÕES
        if (!AppSettingsModel::all()->first()) {
            $save_data = new AppSettingsModel();
            $save_data->logo_url = 'img\gourmetconnect-logo\gourmetconnect.png';
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
        // USUARIOS
        // FORMAS DE PAGAMENTO
    }
}
