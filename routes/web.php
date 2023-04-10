<?php

use App\Http\Controllers\AppSettingsController;
use App\Http\Controllers\AppViewsController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RequestsController;
use Illuminate\Support\Facades\Route;

// Login routes
Route::get('/', [LoginController::class, 'login'])->name('login');

// ESTABLISHMENT ROUTES
// Views rutes
Route::get('administrator/control-panel', [AppViewsController::class, 'control_panel'])->name('control_panel');
Route::get('administrator/requests', [AppViewsController::class, 'requests'])->name('requests');
Route::get('administrator/requests/close-request/{id}', [AppViewsController::class, 'close_request'])->name('close-request');
Route::get('administrator/delivery', [AppViewsController::class, 'delivery'])->name('delivery');
Route::get('administrator/tables', [AppViewsController::class, 'tables'])->name('tables');
Route::get('administrator/menu', [AppViewsController::class, 'menu'])->name('menu');
Route::get('administrator/users', [AppViewsController::class, 'users'])->name('users');
Route::get('administrator/app-settings', [AppViewsController::class, 'app_settings'])->name('app_settings');
Route::get('administrator/site-settings', [AppViewsController::class, 'site_settings'])->name('site_settings');

// App Settings Routes
Route::post('administrator/post/save/establishment-settings', [AppSettingsController::class, 'save_establishment_settings']);
Route::post('administrator/post/save/theme-settings', [AppSettingsController::class, 'save_theme_settings']);
Route::post('administrator/post/save/general-settings', [AppSettingsController::class, 'save_general_settings']);

// APP ROUTES CARDÁPIO
// CRIAR
Route::post('administrator/post/save/menu/type/new', [MenuController::class, 'save_new_type_item']);
Route::post('administrator/post/save/menu/item/new', [MenuController::class, 'save_new_item']);
Route::post('administrator/post/save/menu/additional-item/new', [MenuController::class, 'save_new_additional_item']);
// EDITAR
Route::post('administrator/post/save/menu/type/edit', [MenuController::class, 'edit_type_item']);
Route::post('administrator/post/save/menu/item/edit', [MenuController::class, 'edit_item']);
Route::post('administrator/post/save/menu/additional-item/edit', [MenuController::class, 'edit_additional_item']);
// DELETE
Route::post('administrator/post/delete/menu/type', [MenuController::class, 'delete_type_item']);
Route::post('administrator/post/delete/menu/item', [MenuController::class, 'delete_item']);
Route::post('administrator/post/delete/menu/additional-item', [MenuController::class, 'delete_additional_item']);
// INFORMAÇÕES
Route::post('administrator/post/info/menu/type', [MenuController::class, 'info_type_item']);
Route::post('administrator/post/info/menu/item', [MenuController::class, 'info_item']);
Route::post('administrator/post/info/menu/additional-item', [MenuController::class, 'info_additional_item']);
Route::get('administrator/get/info/menu/types', [MenuController::class, 'all_types']);
Route::get('administrator/get/info/menu/items', [MenuController::class, 'all_items']);
Route::get('administrator/get/info/menu/types', [MenuController::class, 'all_types']);

// TABELAS
Route::post('administrator/post/table/menu/type', [MenuController::class, 'table_type_item']);
Route::post('administrator/post/table/menu/items', [MenuController::class, 'table_item']);
Route::post('administrator/post/table/menu/additional-items', [MenuController::class, 'table_additional_items']);

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

// INFORMAÇOES DO DELIVERY
Route::post('administrator/post/delivery/client/delivery-view', [DeliveryController::class, 'delivery_client_view']);

// TABELAS
Route::post('administrator/post/table/delivery/all', [DeliveryController::class, 'delivery_table']);

// NOTIFICAÇÃO
Route::get('administrator/notification/events', [NotificationController::class, 'notification']);
Route::post('administrator/notification/events/requests', [NotificationController::class, 'new_request_notification']);

Route::get('teste', function () {

});

//ROTA DE INSTALAÇÃO DO SISTEMA
// Esta rota so pode ser acessada caso o sistema ainda não tenha sido instalado no servidor
Route::get('projeto-x/installation/start', [AppSettingsController::class, 'installation']);
