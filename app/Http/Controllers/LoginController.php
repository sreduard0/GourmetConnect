<?php

namespace App\Http\Controllers;

class LoginController extends Controller
{
    public function login()
    {

        session()->put([
            'user' => [
                'id' => 1,
                'name' => 'Eduardo Martins',
                'photo' => 'img/avatar.png',
                'permissions' => [
                    'dashboard' => true,
                    'requests' => true,
                    'menu' => true,
                    'users' => true,
                    'site' => true,
                    'app' => true,
                ],
                'email' => 'dudu.martins@gmail.com',
            ],

            'theme' => [
                'background' => 'dark-mode',
                'sidebar' => 'sidebar-dark-danger',
                'accent-color' => 'accent-danger',

            ],

        ]);
        return redirect()->route('control_panel');
    }
}
