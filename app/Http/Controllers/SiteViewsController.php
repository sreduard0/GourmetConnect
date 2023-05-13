<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\RequestsItemsModel;
use App\Models\TypeItemModel;
use Illuminate\Support\Facades\DB;

class SiteViewsController extends Controller
{
    public function home_page()
    {
        $data = [
            'banners' => AgendaController::show_banner(),
            'items' => ItemModel::with('like')->latest()->orderBy('type_id', 'asc')->get(),
            'promo' => ItemModel::with('like')->whereColumn('old_value', '>', 'value')->latest()->take(15)->orderBy('type_id', 'asc')->get(),
            'types' => TypeItemModel::latest()->take(15)->get(),
            'more_requests' => RequestsItemsModel::select('product_id', DB::raw('COUNT(product_id) as total_quantity'))->with('product')->whereMonth('updated_at', date('m'))->whereYear('updated_at', date('Y'))->where('status', 4)
                ->groupBy('product_id')->orderBy('total_quantity', 'desc')->take(10)->get(),
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
