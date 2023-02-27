<?php

use App\Http\Controllers\EstablishmentViewsController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Login routes
Route::get('/', [LoginController::class, 'login'])->name('login');

// Dashboard routes
Route::get('/control-panel', [EstablishmentViewsController::class, 'control_panel'])->name('control_panel');
Route::get('/requests', [EstablishmentViewsController::class, 'requests'])->name('requests');
Route::get('/menu', [EstablishmentViewsController::class, 'menu'])->name('menu');
Route::get('/users', [EstablishmentViewsController::class, 'users'])->name('users');
Route::get('/app-settings', [EstablishmentViewsController::class, 'app_settings'])->name('app_settings');
