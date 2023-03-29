<?php

use App\Http\Controllers\AppSettingsController;
use App\Http\Controllers\AppViewsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RequestsController;
use App\Models\RequestsItemsModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Login routes
Route::get('/', [LoginController::class, 'login'])->name('login');

// ESTABLISHMENT ROUTES

// Views rutes
Route::get('administrator/control-panel', [AppViewsController::class, 'control_panel'])->name('control_panel');
Route::get('administrator/requests', [AppViewsController::class, 'requests'])->name('requests');
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

//APP ROUTES CARDÁPIO
// CRIAR
Route::post('/administrator/post/save/menu/type/new', [MenuController::class, 'save_new_type_item']);
Route::post('/administrator/post/save/menu/item/new', [MenuController::class, 'save_new_item']);
Route::post('/administrator/post/save/menu/additional-item/new', [MenuController::class, 'save_new_additional_item']);
// EDITAR
Route::post('/administrator/post/save/menu/type/edit', [MenuController::class, 'edit_type_item']);
Route::post('/administrator/post/save/menu/item/edit', [MenuController::class, 'edit_item']);
Route::post('/administrator/post/save/menu/additional-item/edit', [MenuController::class, 'edit_additional_item']);
// DELETE
Route::post('/administrator/post/delete/menu/type', [MenuController::class, 'delete_type_item']);
Route::post('/administrator/post/delete/menu/item', [MenuController::class, 'delete_item']);
Route::post('/administrator/post/delete/menu/additional-item', [MenuController::class, 'delete_additional_item']);
// INFORMAÇÕES
Route::post('/administrator/post/info/menu/type', [MenuController::class, 'info_type_item']);
Route::post('/administrator/post/info/menu/item', [MenuController::class, 'info_item']);
Route::post('/administrator/post/info/menu/additional-item', [MenuController::class, 'info_additional_item']);
Route::get('/administrator/get/info/menu/types', [MenuController::class, 'all_types']);
Route::get('/administrator/get/info/menu/items', [MenuController::class, 'all_items']);
// TABELAS
Route::post('/administrator/post/table/menu/type', [MenuController::class, 'table_type_item']);
Route::post('/administrator/post/table/menu/items', [MenuController::class, 'table_item']);
Route::post('/administrator/post/table/menu/additional-items', [MenuController::class, 'table_additional_items']);

// APP ROUTES PEDIDOS
// ADICIONAR
Route::post('administrator/post/request/item/add', [RequestsController::class, 'add_item_request']);
// DELETAR
Route::post('administrator/post/request/item/delete', [RequestsController::class, 'delete_item_request']);
// ENVIAR
Route::post('administrator/post/request/item/send', [RequestsController::class, 'send_item_request']);
Route::post('administrator/post/request/additional-item/save', [RequestsController::class, 'save_obs_item_request']);

//INFORMAÇOES DE PEDIDOS
Route::post('administrator/post/info/table/client', [RequestsController::class, 'client_table']);
Route::post('administrator/post/request/item/additionals', [RequestsController::class, 'additionals_items_request']);
Route::post('administrator/post/request/client/requests-view', [RequestsController::class, 'requests_client_view']);

//TABELAS
Route::post('administrator/post/table/request/client', [RequestsController::class, 'request_client_table']);
Route::post('administrator/post/table/request/client-view', [RequestsController::class, 'request_client_view']);
Route::post('administrator/post/table/request/list-items-equals', [RequestsController::class, 'list_items_equals']);
Route::post('administrator/post/table/request/all', [RequestsController::class, 'all_request_table']);
Route::post('administrator/post/table/request/menu', [RequestsController::class, 'table_menu']);

// NOTIFICAÇÃO
Route::get('administrator/notification/events', [NotificationController::class, 'notification']);
Route::get('teste', function () {
    $dd = RequestsItemsModel::with('product')->select('product_id', DB::raw('COUNT(id) as count'))
        ->where('request_id', 1)
        ->where('status', '>', 1)
        ->groupBy('product_id')
        ->get();
    dd(
        count($dd)
    );

});

//ROTA DE INSTALAÇÃO DO SISTEMA
// Esta rota so pode ser acessada caso o sistema ainda não tenha sido instalado no servidor
Route::get('projeto-x/installation/start', [AppSettingsController::class, 'installation']);
