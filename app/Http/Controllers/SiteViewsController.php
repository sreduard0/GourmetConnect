<?php

namespace App\Http\Controllers;

use App\Models\AppSettingsModel;
use App\Models\CommentsModel;
use App\Models\DeliveryLocationsModel;
use App\Models\ItemModel;
use App\Models\PaymentMethodsModel;
use App\Models\RequestsItemsModel;
use App\Models\TypeItemModel;
use App\Models\UsersClientModel;
use Illuminate\Support\Facades\DB;

class SiteViewsController extends Controller
{
    public function home_page()
    {
        $data = [
            'banners' => AgendaController::show_banner(),
            'items' => ItemModel::with('like')->take(15)->latest()->orderBy('type_id', 'asc')->get(),
            'promo' => ItemModel::with('like')->whereColumn('old_value', '>', 'value')->latest()->take(15)->orderBy('type_id', 'asc')->get(),
            'types' => TypeItemModel::latest()->get(),
            'more_requests' => RequestsItemsModel::select('product_id', DB::raw('COUNT(product_id) as total_quantity'))->with('product')->whereMonth('updated_at', date('m'))->whereYear('updated_at', date('Y'))->where('status', 4)
                ->groupBy('product_id')->orderBy('total_quantity', 'desc')->take(10)->get(),
            'comments' => CommentsModel::with('client')->take(15)->latest()->get(),

        ];
        return view('site.home-page', $data);
    }
    public function menu()
    {
        $data = [
            'items' => ItemModel::with('like')->take(15)->latest()->orderBy('type_id', 'asc')->get(),
            'promo' => ItemModel::with('like')->whereColumn('old_value', '>', 'value')->latest()->take(15)->orderBy('type_id', 'asc')->get(),
            'types' => TypeItemModel::latest()->get(),
            'more_requests' => RequestsItemsModel::select('product_id', DB::raw('COUNT(product_id) as total_quantity'))->with('product')->whereMonth('updated_at', date('m'))->whereYear('updated_at', date('Y'))->where('status', 4)
                ->groupBy('product_id')->orderBy('total_quantity', 'desc')->take(10)->get(),
        ];
        return view('site.menu', $data);
    }
    public function cart()
    {
        $data = [
            'items' => ItemModel::with('like')->take(15)->latest()->orderBy('type_id', 'asc')->get(),
            'locations' => DeliveryLocationsModel::all(),
            'payment_methods' => PaymentMethodsModel::where('active', 1)->get(),
            'user' => UsersClientModel::with('location')->where('login_id', auth()->guard('client')->id())->first(),
        ];
        return view('site.cart', $data);
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
    public function form_login()
    {
        $data = [
            'app_settings' => AppSettingsModel::first(),
        ];

        return view('site.login.form-login', $data);
    }
}
