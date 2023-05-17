<?php

namespace App\Http\Controllers;

use App\Classes\Email;
use App\Models\LoginClientModel;
use App\Models\UsersClientModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $auth_data = Socialite::driver('google')->user();
            // VERIFICAR SE USUÁRIO EXISTE
            $login = LoginClientModel::where('google_id', $auth_data->user['id'])->first();
            if ($login) {
                auth()->guard('client')->login($login);
                $user = UsersClientModel::where('login_id', auth()->guard('client')->id())->first();
                session()->put([
                    'user' => [
                        'name' => $user->first_name,
                        'photo' => $user->photo_url,
                        'email' => $user->email,
                    ],
                ]);

                return redirect()->route('home_page');
            } else {
                if (UsersClientModel::where('email', $auth_data->user['email'])->exists()) {
                    return ['error' => true, 'message' => 'Há um usuário com este e-mail'];
                }
                $create_login = new LoginClientModel();
                $create_login->google_id = $auth_data->user['id'];
                $create_login->active = 1;
                $create_login->login = $auth_data->user['email'];
                $pass = Str::random(8);
                $create_login->password = Hash::make($pass);

                if ($create_login->save()) {
                    if ($auth_data->user['picture']) {
                        $imageData = file_get_contents(str_replace('=s96-c', '=s300-p', $auth_data->user['picture']));
                        $fileName = $auth_data->user['id'] . $auth_data->user['given_name'] . '-user.jpg';
                        $fileDir = 'img/clients-pictures/';
                        if (!is_dir($fileDir)) {
                            mkdir($fileDir, 0444, true); //444
                        }
                        file_put_contents($fileDir . $fileName, $imageData);
                    }

                    $create_user = new UsersClientModel();
                    $create_user->login_id = $create_login->id;
                    $create_user->photo_url = $auth_data->user['picture'] ? $fileDir . $fileName : 'img/avatar/user.png';
                    $create_user->first_name = $auth_data->user['given_name'];
                    $create_user->last_name = $auth_data->user['family_name'];
                    $create_user->email = $auth_data->user['email'];
                    if ($create_user->save()) {
                        auth()->guard('client')->attempt(['google_id' => $auth_data->user['id'], 'password' => $pass]);
                        $user = UsersClientModel::where('login_id', auth()->guard('client')->id())->first();
                        session()->put([
                            'user' => [
                                'name' => $user->first_name,
                                'photo' => $user->photo_url,
                                'email' => $user->email,
                            ],
                        ]);

                        return redirect()->route('home_page');
                    } else {
                        LoginClientModel::find($create_login->id)->delete();
                        return ['error' => true, 'message' => 'ERRO AO CRIAR USUÁRIO'];
                    }
                } else {
                    return ['error' => true, 'message' => 'ERRO AO CRIAR USUÁRIO'];
                }

            }
        } catch (\Throwable $th) {
            return ['error' => true, 'message' => $th->getMessage()];
        }
    }

}
