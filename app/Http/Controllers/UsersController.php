<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\LoginAppModel;
use App\Models\UsersAppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    // CRIAR USUÁRIOS
    public function create(Request $request)
    {
        $userRequest = $request->all();
        $create_login = new LoginAppModel();
        $create_login->active = $userRequest['user_status'];
        $create_login->login = strtolower($userRequest['user_email']);
        $create_login->password = Hash::make(Str::random(8));

        if ($create_login->save()) {
            if ($userRequest['img_user']) {
                $image_array_1 = explode(";", $userRequest['img_user']);
                $image_array_2 = explode(",", $image_array_1[1]);
                $img = base64_decode($image_array_2[1]);
                $imageName = 'image_profile_' . strtolower($userRequest['first_name']) . date('d-m-Y') . '.png';
                $fileDir = 'private/img/' . strtolower($userRequest['user_email']) . '/';
                Storage::put($fileDir . $imageName, $img);
            }
            $create_user = new UsersAppModel();
            $create_user->login_id = $create_login->id;
            $create_user->photo_url = $userRequest['img_user'] ? 'private/assets/' . strtolower($userRequest['user_email']) . '/' . $imageName : 'img/avatar/user.png';
            $create_user->first_name = ucfirst(strtolower($userRequest['first_name']));
            $create_user->last_name = ucfirst(strtolower($userRequest['last_name']));
            $create_user->job = strtoupper($userRequest['user_job']);
            $create_user->phone = str_replace(['(', ')', '-', ' '], '', $userRequest['user_phone']);
            $create_user->email = strtolower($userRequest['user_email']);

            if ($create_user->save()) {
                // envia email para para usuario
                return ['error' => false, 'message' => 'Usuário criado com sucesso'];
            } else {
                LoginAppModel::find($create_login->id)->delete();
                return ['error' => true, 'message' => 'Erro ao criar usuário'];
            }
        } else {
            return ['error' => true, 'message' => 'Erro ao criar usuário'];
        }
    }
    // FORM EDITAR USUARIO
    public function edit($id)
    {

    }
    // EDITAR USUÁRIOS
    public function update(Request $request)
    {

    }
    // DELETAR USUÁRIOS
    public function delete($id)
    {

    }
    // TABELA DATATABLES DE USUÁRIOS
    public function table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'users_app.first_name',
            1 => 'users_app.phone',
            2 => 'users_app.email',
            3 => 'login_app.active',
            4 => 'users_app.id',
            5 => 'users_app.id',
        );

        if ($requestData['columns'][1]['search']['value']) {
            $nameParts = explode(" ", $requestData['columns'][1]['search']['value']);
            $query = UsersAppModel::join('login_app', 'users_app.login_id', '=', 'login_app.id')
                ->where('first_name', 'LIKE', '%' . $nameParts[0] . '%');
            if (isset($nameParts[1])) {
                $query->where('last_name', 'LIKE', '%' . $nameParts[1] . '%');
            }
            $users = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();

            $count = UsersAppModel::where('first_name', 'LIKE', '%' . $nameParts[0] . '%');
            if (isset($nameParts[1])) {
                $count->where('last_name', 'LIKE', '%' . $nameParts[1] . '%');
            }
            $rows = count($count->get());
        } else {
            $users = UsersAppModel::join('login_app', 'users_app.login_id', '=', 'login_app.id')
                ->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();

            $rows = count(UsersAppModel::all());
        }
        $filtered = count($users);
        $dados = array();
        foreach ($users as $user) {
            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($user->photo_url) . '" alt="' . $user->first_name . '" width="35">
                        <div class="popup">
                            <img src="' . asset($user->photo_url) . '" alt="' . $user->first_name . '">
                        </div>';
            $dado[] = $user->first_name . ' ' . $user->last_name;
            $dado[] = Tools::mask('(##) # ####-####', $user->phone);
            $dado[] = $user->email;
            $dado[] = $user->job;
            $dado[] = $user->active == 1 ? 'Ativo' : 'Inativo';
            $dado[] = 'admin';
            $dado[] = '<button onclick="return modal_item(\'' . Tools::hash($user->id, 'encrypt') . '\')" class="btn btn-sm btn-warning"><i class="fa-solid fa-user-shield"></i></button> <button onclick="return modal_item(\'' . Tools::hash($user->id, 'encrypt') . '\')" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></button> <button onclick="return delete_item(\'' . Tools::hash($user->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }

}
