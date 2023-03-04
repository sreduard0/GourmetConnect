<?php

use App\Http\Controllers\AppSettingsController;
use App\Http\Controllers\AppViewsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

// Login routes
Route::get('/', [LoginController::class, 'login'])->name('login');

// ESTABLISHMENT ROUTES

// Views rutes
Route::get('administrator/control-panel', [AppViewsController::class, 'control_panel'])->name('control_panel');
Route::get('administrator/requests', [AppViewsController::class, 'requests'])->name('requests');
Route::get('administrator/tables', [AppViewsController::class, 'tables'])->name('tables');
Route::get('administrator/menu', [AppViewsController::class, 'menu'])->name('menu');
Route::get('administrator/users', [AppViewsController::class, 'users'])->name('users');
Route::get('administrator/app-settings', [AppViewsController::class, 'app_settings'])->name('app_settings');
Route::get('administrator/site-settings', [AppViewsController::class, 'site_settings'])->name('site_settings');

// App Settings Routes
Route::post('administrator/post/save/establishment-settings', [AppSettingsController::class, 'save_establishment_settings']);
Route::post('administrator/post/save/theme-settings', [AppSettingsController::class, 'save_theme_settings']);
Route::post('administrator/post/save/general-settings', [AppSettingsController::class, 'save_general_settings']);
//App Menu Routes
Route::post('/administrator/post/save/menu/type/new', [MenuController::class, 'save_new_type_item']);
Route::post('/administrator/post/table/menu/type', [MenuController::class, 'table_type_item'])->name('table_type_item');
Route::post('/administrator/post/table/menu/items', [MenuController::class, 'table_item'])->name('table_item');

//ROTA DE INSTALAÇÃO DO SISTEMA
// Esta rota so pode ser acessada caso o sistema ainda não tenha sido instalado no servidor
Route::get('projeto-x/installation/start', [AppSettingsController::class, 'installation']);
