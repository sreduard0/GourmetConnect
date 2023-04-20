<?php

use App\Classes\Calculate;
use App\Http\Controllers\AdditionalItemsController;
use App\Http\Controllers\AppSettingsController;
use App\Http\Controllers\AppViewsController;
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\TypeItemsController;
use App\Models\RequestsModel;
use Illuminate\Support\Facades\Route;

// Login routes
Route::get('/', [LoginController::class, 'login'])->name('login');

// ----------------------------
// APP VIEWS
// ----------------------------
Route::get('administrator/control-panel', [AppViewsController::class, 'control_panel'])->name('control_panel');
Route::get('administrator/requests', [AppViewsController::class, 'requests'])->name('requests');
Route::get('administrator/requests/close-request/{id}', [AppViewsController::class, 'close_request'])->name('close-request');
Route::get('administrator/delivery', [AppViewsController::class, 'delivery'])->name('delivery');
Route::get('administrator/tables', [AppViewsController::class, 'tables'])->name('tables');
Route::get('administrator/menu', [AppViewsController::class, 'menu'])->name('menu');
Route::get('administrator/users', [AppViewsController::class, 'users'])->name('users');
Route::get('administrator/app-settings', [AppViewsController::class, 'app_settings'])->name('app_settings');
Route::get('administrator/site-settings', [AppViewsController::class, 'site_settings'])->name('site_settings');

// -----------------------------
// APP SETTINGS
// -----------------------------
Route::post('administrator/post/save/establishment-settings', [AppSettingsController::class, 'save_establishment_settings']);
Route::post('administrator/post/save/theme-settings', [AppSettingsController::class, 'save_theme_settings']);
Route::post('administrator/post/delete/delivery/local', [AppSettingsController::class, 'delete_delivery_local']);
Route::post('administrator/post/save/delivery-local-settings', [AppSettingsController::class, 'save_delivery_local_settings']);
Route::post('administrator/post/table/app-settings/delivery-locations', [AppSettingsController::class, 'delivery_locations']);
Route::get('administrator/get/app-settings/logo', [AppSettingsController::class, 'logo']);

// ------------------------------
// APP/ CARDÁPIO
// ------------------------------
// TIPO ITENS
Route::post('administrator/post/save/menu/type/new', [TypeItemsController::class, 'create']);
Route::put('administrator/put/save/menu/type/edit', [TypeItemsController::class, 'update']);
Route::delete('administrator/delete/menu/type/{id}', [TypeItemsController::class, 'delete']);
Route::post('administrator/post/info/menu/type', [TypeItemsController::class, 'find']);
Route::get('administrator/get/info/menu/types', [TypeItemsController::class, 'all_name_types']);
Route::post('administrator/post/table/menu/type', [TypeItemsController::class, 'table']);
// ITENS
Route::post('administrator/post/save/menu/item/new', [ItemsController::class, 'create']);
Route::put('administrator/put/save/menu/item/edit', [ItemsController::class, 'update']);
Route::delete('administrator/delete/menu/item/{id}', [ItemsController::class, 'delete']);
Route::post('administrator/post/info/menu/item', [ItemsController::class, 'find']);
Route::get('administrator/get/info/menu/items', [ItemsController::class, 'all_name_items']);
Route::post('administrator/post/table/menu/items', [ItemsController::class, 'table']);
// ADICIONAIS
Route::post('administrator/post/save/menu/additional-item/new', [AdditionalItemsController::class, 'create']);
Route::put('administrator/put/save/menu/additional-item/edit', [AdditionalItemsController::class, 'update']);
Route::delete('administrator/delete/menu/additional-item/{id}', [AdditionalItemsController::class, 'delete']);
Route::post('administrator/post/info/menu/additional-item', [AdditionalItemsController::class, 'find']);
Route::post('administrator/post/table/menu/additional-items', [AdditionalItemsController::class, 'table']);

//-------------------------------
// APP/ PEDIDOS
//-------------------------------
// ESTABELECIMENTO
Route::post('administrator/post/order/new', [OrderController::class, 'create']);
Route::delete('administrator/delete/order/{id}', [OrderController::class, 'delete']);
Route::get('administrator/get/table/orders/{table}', [OrderController::class, 'table_orders_list']);
Route::get('administrator/get/order/requests/{id}', [OrderController::class, 'order_requests']);
Route::get('administrator/get/check/order/finish/{id}', [OrderController::class, 'check_order_finish']);
Route::post('administrator/post/table/orders', [OrderController::class, 'table']);

// DELIVERY

// PEDIDOS
Route::post('administrator/post/request/item/add', [RequestsController::class, 'add_item_request']);
Route::post('administrator/post/request/item/delete', [RequestsController::class, 'delete_item_request']);
Route::post('administrator/post/request/item/send', [RequestsController::class, 'send_item_request']);
Route::post('administrator/post/request/additional-item/save', [RequestsController::class, 'save_obs_item_request']);
Route::post('administrator/post/request/print', [RequestsController::class, 'print_request']);
Route::post('administrator/post/request/print/confirm', [RequestsController::class, 'print_confirm']);
Route::post('administrator/post/request/item/additionals', [RequestsController::class, 'additionals_items_request']);
Route::post('administrator/post/info/request/item', [RequestsController::class, 'view_item_request']);
Route::post('administrator/post/request/finalize-payment', [RequestsController::class, 'finalize_payment']);
Route::post('administrator/post/request/tax-coupon', [RequestsController::class, 'tax_coupon']);
Route::post('administrator/post/table/request/client', [RequestsController::class, 'request_client_table']);
Route::post('administrator/post/table/request/client-view', [RequestsController::class, 'request_client_view']);
Route::post('administrator/post/table/request/client-payment/{id}', [RequestsController::class, 'client_payment']);
Route::post('administrator/post/sum/request/client-payment', [RequestsController::class, 'sum_requests_client']);
Route::post('administrator/post/table/request/list-items-equals', [RequestsController::class, 'list_items_equals']);
Route::post('administrator/post/table/request/menu', [RequestsController::class, 'table_menu']);
Route::post('administrator/post/table/request/split-payment', [RequestsController::class, 'split_payment_table']);
Route::post('administrator/post/delivery/request/new', [DeliveryController::class, 'new_delivery']);
Route::post('administrator/post/delivery/status/send', [DeliveryController::class, 'out_for_delivery']);
Route::post('administrator/post/delivery/status/finalize', [DeliveryController::class, 'finalize_delivery']);
Route::post('administrator/post/delivery/client/delivery-view', [DeliveryController::class, 'delivery_client_view']);
Route::post('administrator/post/table/delivery/all', [DeliveryController::class, 'delivery_table']);
Route::post('administrator/post/table/delivery/client', [DeliveryController::class, 'delivery_client_table']);

// MESAS
Route::get('administrator/post/table/events', [TablesController::class, 'tables_events']);
Route::post('administrator/post/table/info/clients', [TablesController::class, 'table_info']);

// APP ROUTES PAINEL DE CONTROLE
// VENDAS MENSAIS
Route::get('administrator/get/control-panel/chart/monthly-sales-chart', [ControlPanelController::class, 'monthly_sales_chart']);
Route::get('administrator/get/control-panel/chart/areas-with-more-delivery', [ControlPanelController::class, 'areas_with_more_delivery']);

// NOTIFICAÇÃO
Route::get('administrator/notification/events', [NotificationController::class, 'notification']);
Route::post('administrator/notification/events/requests', [NotificationController::class, 'new_request_notification']);

Route::get('table/request/qr-code/client/{table}', function ($table) {
    return $table;
});
Route::get('teste', function () {
    $local = RequestsModel::select('id')->where('delivery', 0)->where('status', 2)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->get()->toArray();
    $local_old = RequestsModel::select('id')->where('delivery', 0)->where('status', 2)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m', strtotime('-1 month')))->get()->toArray();

    $statistics['local'] = [
        'percentage' => Calculate::percentage(Calculate::requestValue($local_old, 4), Calculate::requestValue($local, 4), true),
    ];
    dd($statistics);

});
