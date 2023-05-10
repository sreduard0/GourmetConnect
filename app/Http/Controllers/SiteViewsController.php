<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\TypeItemModel;

class SiteViewsController extends Controller
{
    public function home_page()
    {
        $data = [
            'banners' => AgendaController::show_banner(),
            'items' => ItemModel::latest()->take(15)->orderBy('type_id', 'asc')->get(),
            'promo' => ItemModel::whereColumn('old_value', '>', 'value')->latest()->take(15)->orderBy('type_id', 'asc')->get(),
            'types' => TypeItemModel::latest()->take(15)->get(),
        ];
        return view('site.home-page', $data);
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
