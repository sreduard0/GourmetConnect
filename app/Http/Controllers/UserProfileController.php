<?php

namespace App\Http\Controllers;

use App\Models\LoginAppModel;
use App\Models\UsersAppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function show()
    {
        $login = LoginAppModel::find(auth()->id());
        $user = [
            'user' => UsersAppModel::where('users_app.login_id', auth()->id())
                ->join('login_app', 'users_app.login_id', 'login_app.id')
                ->select(['login_app.active', 'users_app.*'])
                ->first(),
            'permissions' => $login->permissions,
        ];
        return $user;
    }

    // EDITAR USUÁRIOS
    public function update(Request $request)
    {
        $profileRequest = $request->all();

        // BUSCANDO DADOS DO USUARIO
        $edit_user = UsersAppModel::where('login_id', auth()->id())->first();

        // CHECANDO SE EMAIL QUE FOI ALTERADO JA EXISTE
        $check_email = UsersAppModel::where('email', $profileRequest['user_email'])->first();
        if ($check_email && $check_email->id != $edit_user->id) {
            return ['error' => true, 'message' => 'Há um usuário com este e-mail'];
        }

        // VERIFICANDO SE A FOTO DE PERFIL FOI ALTERADA E SALVANDO NO CAMPO
        if ($profileRequest['img_user']) {
            $image_array_1 = explode(";", $profileRequest['img_user']);
            $image_array_2 = explode(",", $image_array_1[1]);
            $img = base64_decode($image_array_2[1]);
            $imageName = 'image_profile_' . strtolower($profileRequest['first_name']) . '.png';
            $fileDir = 'private/img/' . strtolower($profileRequest['user_email']) . '/';
            Storage::delete($fileDir . $imageName);
            Storage::put($fileDir . $imageName, $img);
            $edit_user->photo_url = 'private/assets/' . strtolower($profileRequest['user_email']) . '/' . $imageName;
        }

        // SALVANDO OUTRAS INFORMAÇOES
        $edit_user->first_name = ucfirst(strtolower($profileRequest['first_name']));
        $edit_user->last_name = ucfirst(strtolower($profileRequest['last_name']));
        $edit_user->phone = str_replace(['(', ')', '-', ' '], '', $profileRequest['user_phone']);
        $edit_user->email = $profileRequest['user_email'];

        // BUSCANDO DADOS DO LOGIN
        $edit_login = LoginAppModel::find($edit_user->login_id);
        $edit_login->login = $profileRequest['user_email'];

        if ($edit_user->save()) {
            if ($edit_login->save()) {
                session()->put([
                    'user' => [
                        'name' => $edit_user->first_name,
                        'photo' => $edit_user->photo_url,
                        'email' => $edit_user->email,
                    ],
                ]);

                return ['error' => false, 'message' => $edit_user->photo_url];
            }
        } else {
            return ['error' => true, 'message' => 'ERRO AO EDITAR PERFIL'];
        }
    }

    // ALTERAÇÂO DE SENHA
    public function update_password(Request $request)
    {
        $login = LoginAppModel::find(auth()->id());
        if (Hash::check(trim($request->get('currentPass')), trim($login->password))) {
            if ($request->get('newPass') === $request->get('repNewPass')) {
                $login->password = Hash::make(trim($request->get('newPass')));
                if ($login->save()) {
                    return ['error' => false, 'message' => 'SENHA ALTERADA'];
                }
            }
            return ['error' => true, 'message' => 'AS SENHAS DEVEM SER IGUAIS!'];
        }
        return ['error' => true, 'message' => 'SENHA ATUAL ESTA INCORRETA'];
    }
}
