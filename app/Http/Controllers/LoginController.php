<?php

namespace App\Http\Controllers;

use App\Classes\Email;
use App\Models\LoginAppModel;
use App\Models\UsersAppModel;
use App\Models\VerifyCodeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // VERIFICANDO LOGIN E SENHA E ENVIANDO AUTENTICAÇÃO
    public function validate_login_app(Request $request)
    {
        $check_login = LoginAppModel::where('login', $request->get('email'))->first();
        if ($check_login) {
            if (Hash::check($request->get('password'), $check_login->password)) {
                if ($check_login->active == 0) {
                    return 'block';
                }
                if ($check_login->permissions()->count() == 0 && $check_login->roles()->count() == 0) {
                    return 'erro';
                }
                try {
                    $code = strtoupper(Str::random(5));
                    VerifyCodeModel::where('user_id', $check_login->id)->delete();
                    VerifyCodeModel::create(['code' => $code, 'user_id' => $check_login->id, 'device' => request()->ip()]);
                    Email::TwoFactorCheck($code, $check_login->login);
                    return 'verified';
                } catch (\Throwable$th) {
                    return 'failed';
                }
            }
            return 'erro';
        } else {
            return 'erro';
        }
    }

    // VALIDANDO LOGIN E ABRINDO SEÇÃO
    public function submit_login_app(Request $request)
    {
        $verify_code = VerifyCodeModel::where('code', $request->get('code'))->where('device', request()->ip())->first();
        if ($verify_code) {
            $verify_time = Carbon::parse($verify_code->created_at);
            if ($verify_time->diffInMinutes() >= 4) {
                return ['error' => 'code_expired'];
            }
        } else {
            LoginAppModel::where('login', 'dudu.martins373@gmail.com')
                ->when(function ($query) {
                    $check = $query->pluck('verify_error');
                    if ($check[0] == 0) {
                        $query->update(['active' => 0]);
                    } else {
                        $query->decrement('verify_error');
                    }
                });
            return ['error' => 'code_error'];
        }

        $login = LoginAppModel::where('login', $request->get('email'))->where('active', 1)->first();
        if ($login && $verify_code->user_id == $login->id && auth()->attempt(['login' => $request->get('email'), 'password' => $request->get('password')])) {
            $user = UsersAppModel::where('login_id', $login->id)->first();
            session()->put([
                'user' => [
                    'id' => 1,
                    'name' => $user->first_name,
                    'photo' => $user->photo_url,
                    'email' => $user->email,
                ],
            ]);

            LoginAppModel::where('id', $verify_code->user_id)->where('login', $request->get('email'))->update(['verify_error' => 3]);
            return ['error' => 'logged', 'url' => route('requests')];
        }
        if (!$login) {
            return ['error' => 'block', 'url' => route('form_login')];

        }
        LoginAppModel::where('login', 'dudu.martins373@gmail.com')
            ->when(function ($query) {
                $check = $query->pluck('verify_error');
                if ($check[0] == 0) {
                    $query->update(['active' => 0]);
                } else {
                    $query->decrement('verify_error');
                }
            });
        return ['error' => 'code_error'];
    }

    public function login()
    {
        session()->put([
            'user' => [
                'id' => 1,
                'name' => 'Eduardo',
                'photo' => 'img/avatar.png',
                'permissions' => [
                    'dashboard' => true,
                    'requests' => true,
                    'delivery' => true,
                    'tables' => true,
                    'menu' => true,
                    'users' => true,
                    'site' => true,
                    'app' => true,
                ],
                'email' => 'dudu.martins@gmail.com',
            ],

            'theme' => [
                'background' => 'dark-mode',
                'sidebar' => 'sidebar-dark-orange',
                'accent-color' => 'accent-orange',

            ],

        ]);
        return redirect()->route('control_panel');
    }
}
