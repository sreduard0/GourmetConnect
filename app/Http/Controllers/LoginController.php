<?php

namespace App\Http\Controllers;

use App\Classes\Email;
use App\Classes\TwoFactorCheck;
use App\Models\AppSettingsModel;
use App\Models\LoginAppModel;
use App\Models\UsersAppModel;
use App\Models\VerifyCodeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // VERIFICANDO LOGIN E SENHA E ENVIANDO AUTENTICAÇÃO
    public function validate_login_app(Request $request)
    {
        $check_login = LoginAppModel::where('login', trim($request->get('email')))->first();
        if ($check_login) {
            if (Hash::check(trim($request->get('password')), $check_login->password)) {
                if ($check_login->active == 0) {
                    return 'block';
                }
                if ($check_login->permissions()->count() == 0 && $check_login->roles()->count() == 0) {
                    return 'erro';
                }
                $check_smtp = AppSettingsModel::first();
                if ($check_smtp->mailer_email) {
                    try {
                        $code = strtoupper(Str::random(5));
                        VerifyCodeModel::where('user_id', $check_login->id)->delete();
                        VerifyCodeModel::create(['code' => $code, 'user_id' => $check_login->id, 'device' => request()->ip()]);
                        Email::TwoFactorCheck($code, $check_login->login);
                        return 'verified';
                    } catch (\Throwable $th) {
                        return 'failed';
                    }

                } else {
                    return 'not-smtp';
                }
            }
            Log::channel('logins')->error('SENHA INCORRETA:', ['EMAIL:' => trim($request->get('email')), 'SENHA:' => trim($request->get('password')), 'IP:' => request()->ip()]);
            return 'erro';
        } else {
            Log::channel('logins')->error('LOGIN INCORRETO:', ['EMAIL:' => trim($request->get('email')), 'SENHA:' => trim($request->get('password')), 'IP:' => request()->ip()]);
            return 'erro';
        }
    }

    // VALIDANDO LOGIN E ABRINDO SEÇÃO
    public function submit_login_app(Request $request)
    {
        $login = LoginAppModel::where('login', trim($request->get('email')))->where('active', 1)->first();
        if (!$login) {
            return ['error' => 'block', 'url' => route('form_login')];
        }
        $check_smtp = AppSettingsModel::first();
        if ($check_smtp->mailer_email) {
            $verify_code = VerifyCodeModel::where('code', $request->get('code'))->where('device', request()->ip())->first();
            if ($verify_code) {
                if (TwoFactorCheck::codeExpired($request->get('code'))) {
                    return ['error' => 'code_expired'];
                }
            } else {
                TwoFactorCheck::codeError($request->get('email'));
                return ['error' => 'code_error'];
            }

            if (TwoFactorCheck::codeVerify($request->get('email'), $request->get('code')) && auth()->attempt(['login' => trim($request->get('email')), 'password' => trim($request->get('password'))])) {
                $user = UsersAppModel::where('login_id', $login->id)->first();
                session()->put([
                    'user' => [
                        'name' => $user->first_name,
                        'photo' => $user->photo_url,
                        'email' => $user->email,
                    ],
                ]);
                return ['error' => 'logged', 'url' => TwoFactorCheck::successLogin($request->get('email'))];
            }
            Log::channel('logins')->error('ERRO AO LOGAR:', $request->all());
            TwoFactorCheck::codeError($request->get('email'));
            return ['error' => 'code_error'];
        } else {
            if (auth()->attempt(['login' => trim($request->get('email')), 'password' => trim($request->get('password'))])) {
                $user = UsersAppModel::where('login_id', $login->id)->first();
                session()->put([
                    'user' => [
                        'name' => $user->first_name,
                        'photo' => $user->photo_url,
                        'email' => $user->email,
                    ],
                ]);
                return ['error' => 'logged', 'url' => TwoFactorCheck::successLogin($request->get('email'))];
            }
        }
    }

    // LOGOUT
    public function logout_app()
    {
        session()->flush();
        auth()->logout();
        return redirect()->route('form_login');
    }
    // LOGOUT CLIENTE
    public function logout_client()
    {
        session()->flush();
        auth()->logout();
        return redirect()->route('home_page');
    }
}
