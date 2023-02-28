<?php

namespace App\Http\Controllers;

class EstablishmentViewsController extends Controller
{
    public function control_panel()
    {
        return view('app.control-panel');
    }
    public function requests()
    {
        return view('app.requests');
    }
    public function tables()
    {
        return view('app.tables');
    }
    public function menu()
    {
        return view('app.menu');
    }
    public function users()
    {
        return view('app.users');
    }
    public function app_settings()
    {
        return view('app.app-settings');
    }
    public function site_settings()
    {
        return view('app.site-settings');
    }
}
