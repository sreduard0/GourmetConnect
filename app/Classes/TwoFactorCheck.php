<?php

namespace App\Classes;

use App\Models\LoginAppModel;
use App\Models\VerifyCodeModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TwoFactorCheck
{
    // EXECUTA AÇOES SE O CODIGO ESTA ERRADO
    public static function codeError($email)
    {
        LoginAppModel::where('login', $email)
            ->when(function ($query) {
                $check = $query->pluck('verify_error');
                if ($check[0] == 0) {
                    $query->update(['active' => 0]);
                } else {
                    $query->decrement('verify_error');
                }
            });
    }

    // VERIFICA SE O CODIGO EXPIROU
    public static function codeExpired($code)
    {
        $code = VerifyCodeModel::where('code', $code)->first();
        $verify_time = Carbon::parse($code->created_at);
        if ($verify_time->diffInMinutes() >= 4) {
            return true;
        }
        return false;
    }

    // VERIFICA SE O CODIGO É DO MESMO USUÁRIO
    public static function codeVerify($login, $code)
    {
        $login = LoginAppModel::where('login', $login)->where('active', 1)->first();
        $code = VerifyCodeModel::where('code', $code)->first();
        if ($code->user_id == $login->id) {
            return true;
        }
        return false;
    }
    // LOGIN COM SUCESSO
    public static function successLogin($login)
    {
        $permissions = [
            ['name' => 'dashboard', 'route' => route('control_panel')],
            ['name' => 'view_delivery', 'route' => route('delivery')],
            ['name' => 'view_orders', 'route' => route('requests')],
            ['name' => 'view_tables', 'route' => route('tables')],
            ['name' => 'config_users', 'route' => route('users')],
            ['name' => 'config_app', 'route' => route('app_settings')],
            ['name' => 'config_site', 'route' => route('site_settings')],
        ];
        LoginAppModel::where('login', $login)->update(['verify_error' => 3]);
        foreach ($permissions as $permission) {
            if (Auth::user()->hasPermissionTo($permission['name'])) {
                return $permission['route'];
            }
        }

    }

}
