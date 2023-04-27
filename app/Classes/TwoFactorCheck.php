<?php

namespace App\Classes;

use App\Models\LoginAppModel;
use App\Models\VerifyCodeModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
            ['name' => 'dashboard', 'route' => Redirect::intended(route('control_panel'))->headers->get('Location')],
            ['name' => 'view_delivery', 'route' => Redirect::intended(route('delivery'))->headers->get('Location')],
            ['name' => 'view_orders', 'route' => Redirect::intended(route('requests'))->headers->get('Location')],
            ['name' => 'view_tables', 'route' => Redirect::intended(route('tables'))->headers->get('Location')],
            ['name' => 'config_users', 'route' => Redirect::intended(route('users'))->headers->get('Location')],
            ['name' => 'config_app', 'route' => Redirect::intended(route('app_settings'))->headers->get('Location')],
            ['name' => 'config_site', 'route' => Redirect::intended(route('site_settings'))->headers->get('Location')],
        ];
        LoginAppModel::where('login', $login)->update(['verify_error' => 3]);
        foreach ($permissions as $permission) {
            if (Auth::user()->hasPermissionTo($permission['name'])) {
                return $permission['route'];
            }
        }

    }

}
