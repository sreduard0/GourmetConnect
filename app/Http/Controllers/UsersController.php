<?php

namespace App\Http\Controllers;

use App\Classes\Email;
use App\Classes\Tools;
use App\Models\LoginAppModel;
use App\Models\UsersAppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    // CRIAR USUÁRIOS
    public function create(Request $request)
    {
        $userRequest = $request->all();

        if (UsersAppModel::where('email', strtolower($userRequest['user_email']))->exists()) {
            return ['error' => true, 'message' => 'Há um usuário com este e-mail'];
        }

        $create_login = new LoginAppModel();
        $create_login->active = $userRequest['user_status'];
        $create_login->login = strtolower($userRequest['user_email']);
        $pass = Str::random(8);
        $create_login->password = Hash::make($pass);

        if ($create_login->save()) {
            if ($userRequest['img_user']) {
                $image_array_1 = explode(";", $userRequest['img_user']);
                $image_array_2 = explode(",", $image_array_1[1]);
                $img = base64_decode($image_array_2[1]);
                $imageName = 'image_profile_' . strtolower($userRequest['first_name']) . '.png';
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
            try {
                Email::LoginUser(
                    [
                        'login' => strtolower($userRequest['user_email']),
                        'password' => $pass,
                        'name' => ucfirst(strtolower($userRequest['first_name'])),
                    ],
                    strtolower($userRequest['user_email'])
                );
            } catch (\Throwable$th) {
                return ['error' => true, 'message' => 'ERRO AO ENVIAR E-MAIL COM LOGIN E SENHA.'];
            }

            if ($create_user->save()) {
                return ['error' => false, 'message' => 'Usuário criado com sucesso'];
            } else {
                LoginAppModel::find($create_login->id)->delete();
                return ['error' => true, 'message' => 'ERRO AO CRIAR USUÁRIO'];
            }
        } else {
            return ['error' => true, 'message' => 'ERRO AO CRIAR USUÁRIO'];
        }
    }
    //PREENCHE FORM EDITAR USUARIO
    public function edit($id)
    {
        $query = UsersAppModel::where('users_app.id', Tools::hash($id, 'decrypt'))
            ->join('login_app', 'users_app.login_id', 'login_app.id')
            ->select(['login_app.active', 'users_app.*'])
            ->first();
        return $query;
    }
    // EDITAR USUÁRIOS
    public function update(Request $request)
    {
        $userRequest = $request->all();
        // CHECANDO SE EMAIL QUE FOI ALTERADO JA EXISTE
        $check_email = UsersAppModel::where('email', $userRequest['user_email'])->first();
        if ($check_email && $check_email->id != $userRequest['user_id']) {
            return ['error' => true, 'message' => 'Há um usuário com este e-mail'];
        }

        // BUSCANDO DADOS DO USUARIO
        $edit_user = UsersAppModel::find($userRequest['user_id']);

        // VERIFICANDO SE A FOTO DE PERFIL FOI ALTERADA E SALVANDO NO CAMPO
        if ($userRequest['img_user']) {
            $image_array_1 = explode(";", $userRequest['img_user']);
            $image_array_2 = explode(",", $image_array_1[1]);
            $img = base64_decode($image_array_2[1]);
            $imageName = 'image_profile_' . strtolower($userRequest['first_name']) . '.png';
            $fileDir = 'private/img/' . strtolower($userRequest['user_email']) . '/';
            Storage::delete($fileDir . $imageName);
            Storage::put($fileDir . $imageName, $img);
            $edit_user->photo_url = 'private/assets/' . strtolower($userRequest['user_email']) . '/' . $imageName;
        }

        // SALVANDO OUTRAS INFORMAÇOES
        $edit_user->first_name = ucfirst(strtolower($userRequest['first_name']));
        $edit_user->last_name = ucfirst(strtolower($userRequest['last_name']));
        $edit_user->job = strtoupper($userRequest['user_job']);
        $edit_user->phone = str_replace(['(', ')', '-', ' '], '', $userRequest['user_phone']);

        // BUSCANDO DADOS DO LOGIN
        $edit_login = LoginAppModel::find($edit_user->login_id);
        $edit_login->active = $userRequest['user_status'];

        // VERIFICANDO SE O EMAIL FOI ALTERADO E RESETANDO SENHA E ENVIANDO EMAIL
        if ($edit_user->email != strtolower($userRequest['user_email'])) {
            $edit_user->email = strtolower($userRequest['user_email']);
            $edit_login->login = strtolower($userRequest['user_email']);
            $pass = Str::random(8);
            $edit_login->password = Hash::make($pass);

            try {
                Email::LoginUser(
                    [
                        'login' => strtolower($userRequest['user_email']),
                        'password' => $pass,
                        'name' => ucfirst(strtolower($userRequest['first_name'])),
                    ],
                    strtolower($userRequest['user_email'])
                );
            } catch (\Throwable$th) {
                return ['error' => true, 'message' => 'ERRO AO ENVIAR E-MAIL COM LOGIN E SENHA PARA ' . $userRequest['user_email']];
            }

        }

        if ($edit_user->save()) {
            if ($edit_login->save()) {
                return ['error' => false, 'message' => 'USUÁRIO CRIADO COM SUCESSO'];
            }
        } else {
            return ['error' => true, 'message' => 'ERRO AO EDITAR USUÁRIO'];
        }
    }
    // DELETAR USUÁRIOS
    public function delete($id)
    {
        try {
            $user = UsersAppModel::find(Tools::hash($id, 'decrypt'));
            if (LoginAppModel::find($user->login_id)->delete()) {
                Storage::delete('private/img/' . strtolower($user->email));
                $user->delete();
                return ['error' => false, 'message' => 'Usuário excluído com sucesso'];
            }

        } catch (\Throwable$th) {
            return ['error' => true, 'message' => 'Ouve algum erro, tente novamente.'];
        }
    }
    // PERMISSÕES DE USUÁRIOS
    public function permissions($user)
    {
        $login = LoginAppModel::find(Tools::hash($user, 'decrypt'));
        return $login->permissions;
    }
    // SALVA PERMISSÕES DE USUÁRIOS
    public function save_permissions(Request $request)
    {
        try {
            $login = LoginAppModel::find(Tools::hash($request->get('id'), 'decrypt'));

            foreach (Permission::all() as $permission) {
                $login->revokePermissionTo($permission->name);
            }

            if ($request->get('permissions')) {
                foreach ($request->get('permissions') as $permission) {
                    $login->givePermissionTo($permission);
                }
            }

            return true;
        } catch (\Throwable$th) {
            return false;
        }
    }
    // CHECA EMAIL
    public function check_email($email)
    {
        return UsersAppModel::select('id', 'email')->where('email', $email)->first();
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
                ->get(['login_app.active', 'users_app.*']);

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
                ->get(['login_app.active', 'users_app.*']);

            $rows = count(UsersAppModel::all());
        }
        $filtered = count($users);
        $dados = array();
        foreach ($users as $user) {
            // if ($user->login_id == auth()->id()) {
            //     continue;
            // }
            $login = LoginAppModel::find($user->login_id);
            $buttons = '';
            if (Auth::user()->hasPermissionTo('permissions_user')) {
                $buttons .= '<button onclick="return app_permissions(\'' . Tools::hash($user->login_id, 'encrypt') . '\')" class="btn btn-sm btn-warning"><i class="fa-solid fa-user-shield"></i></button> ';
            }
            if (Auth::user()->hasPermissionTo('edit_user')) {
                $buttons .= '<button onclick="return user_modal(\'update\',\'' . Tools::hash($user->id, 'encrypt') . '\')" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></button> ';
            }
            if (Auth::user()->hasPermissionTo('delete_user')) {
                $buttons .= '<button onclick="return delete_user(\'' . Tools::hash($user->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
            }

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
            $dado[] = '<button class="btn btn-sm btn-accent rounded-pill" onclick="permissions(\'' . Tools::hash($user->login_id, 'encrypt') . '\')"><i class="fa-sharp fa-solid fa-shield-keyhole"></i> <strong>Ver permissões (' . count($login->permissions) . ') </strong></button>';
            $dado[] = $buttons ? $buttons : '-';
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
