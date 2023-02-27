<?php

namespace App\Http\Controllers;

class LoginController extends Controller
{
    public function login()
    {
        return redirect()->route('control_panel');
    }
}
