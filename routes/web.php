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
// APP MENU
// ------------------------------
// TYPE ITEMS
Route::post('administrator/post/save/menu/type/new', [TypeItemsController::class, 'create']);
Route::put('administrator/post/save/menu/type/edit', [TypeItemsController::class, 'update']);
Route::delete('administrator/post/delete/menu/type/{id}', [TypeItemsController::class, 'delete']);
Route::post('administrator/post/info/menu/type', [TypeItemsController::class, 'find']);
Route::get('administrator/get/info/menu/types', [TypeItemsController::class, 'all_name_types']);
Route::post('administrator/post/table/menu/type', [TypeItemsController::class, 'table']);
// ITEMS
Route::post('administrator/post/save/menu/item/new', [ItemsController::class, 'create']);
Route::put('administrator/post/save/menu/item/edit', [ItemsController::class, 'update']);
Route::delete('administrator/post/delete/menu/item/{id}', [ItemsController::class, 'delete']);
Route::post('administrator/post/info/menu/item', [ItemsController::class, 'find']);
Route::get('administrator/get/info/menu/items', [ItemsController::class, 'all_name_items']);
Route::post('administrator/post/table/menu/items', [ItemsController::class, 'table']);
// ADDITIONALS
Route::post('administrator/post/save/menu/additional-item/new', [AdditionalItemsController::class, 'create']);
Route::put('administrator/post/save/menu/additional-item/edit', [AdditionalItemsController::class, 'update']);
Route::delete('administrator/post/delete/menu/additional-item/{id}', [AdditionalItemsController::class, 'delete']);
Route::post('administrator/post/info/menu/additional-item', [AdditionalItemsController::class, 'find']);
Route::post('administrator/post/table/menu/additional-items', [AdditionalItemsController::class, 'table']);

// APP ROUTES PEDIDOS
// ADICIONAR
Route::post('administrator/post/request/item/add', [RequestsController::class, 'add_item_request']);
// DELETAR
Route::post('administrator/post/request/item/delete', [RequestsController::class, 'delete_item_request']);
Route::post('administrator/post/request/delete', [RequestsController::class, 'delete_request']);
// ENVIAR
Route::post('administrator/post/request/item/send', [RequestsController::class, 'send_item_request']);
Route::post('administrator/post/request/additional-item/save', [RequestsController::class, 'save_obs_item_request']);
Route::post('administrator/post/request/print', [RequestsController::class, 'print_request']);
Route::post('administrator/post/request/print/confirm', [RequestsController::class, 'print_confirm']);

// INFORMAÇOES DE PEDIDOS
Route::post('administrator/post/info/table/client', [RequestsController::class, 'client_table']);
Route::post('administrator/post/request/item/additionals', [RequestsController::class, 'additionals_items_request']);
Route::post('administrator/post/request/client/requests-view', [RequestsController::class, 'requests_client_view']);
Route::get('administrator/get/info/request/finish/{id}', [RequestsController::class, 'request_finish']);
Route::post('administrator/post/info/request/item', [RequestsController::class, 'view_item_request']);

// PAGAMENTO
Route::post('administrator/post/request/finalize-payment', [RequestsController::class, 'finalize_payment']);
Route::post('administrator/post/request/tax-coupon', [RequestsController::class, 'tax_coupon']);

// TABELAS
Route::post('administrator/post/table/request/client', [RequestsController::class, 'request_client_table']);
Route::post('administrator/post/table/request/client-view', [RequestsController::class, 'request_client_view']);
Route::post('administrator/post/table/request/client-payment/{id}', [RequestsController::class, 'client_payment']);
Route::post('administrator/post/sum/request/client-payment', [RequestsController::class, 'sum_requests_client']);
Route::post('administrator/post/table/request/list-items-equals', [RequestsController::class, 'list_items_equals']);
Route::post('administrator/post/table/request/all', [RequestsController::class, 'all_request_table']);
Route::post('administrator/post/table/request/menu', [RequestsController::class, 'table_menu']);
Route::post('administrator/post/table/request/split-payment', [RequestsController::class, 'split_payment_table']);

// APP ROUTES DELIVERY
// CRIAR
Route::post('administrator/post/delivery/request/new', [DeliveryController::class, 'new_delivery']);
// SAIU PAARA ENTREGA
Route::post('administrator/post/delivery/status/send', [DeliveryController::class, 'out_for_delivery']);
// FINALIZER DELIERY
Route::post('administrator/post/delivery/status/finalize', [DeliveryController::class, 'finalize_delivery']);

// INFORMAÇOES DO DELIVERY
Route::post('administrator/post/delivery/client/delivery-view', [DeliveryController::class, 'delivery_client_view']);

// TABELAS
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
