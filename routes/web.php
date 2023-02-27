<?php

use App\Http\Controllers\EstablishmentViewsController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Login routes
Route::get('/', [LoginController::class, 'login'])->name('login');

// Dashboard routes
Route::get('/control-panel', [EstablishmentViewsController::class, 'control_panel'])->name('control_panel');
Route::get('/requests', [EstablishmentViewsController::class, 'requests'])->name('requests');
