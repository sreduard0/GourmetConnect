<?php

namespace App\Http\Controllers;

class SiteViewsController extends Controller
{
    public function home_page()
    {
        return view('site.home-page');
    }
    public function about()
    {
        return view('site.about');
    }
    public function agenda()
    {
        return view('site.agenda');
    }
    public function contact()
    {
        return view('site.contact');
    }
}
