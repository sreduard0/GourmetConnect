<?php

use App\Http\Controllers\EstablishmentViewsController;
use Illuminate\Support\Facades\Route;

// Routes for administrators
Route::get('/control-panel', [EstablishmentViewsController::class, 'control_panel'])->name('control_panel');
