<?php

namespace App\Http\Controllers;

class SiteViewsController extends Controller
{
    public function home_page()
    {
        return view('site.home-page');
    }
}
