<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Merchant\AuthController;
use App\Http\Controllers\Agency\AgencyAuthController;

Route::prefix('merchant')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('agency')->group(function () {
    Route::post('/register', [AgencyAuthController::class, 'register']);
    Route::post('/login', [AgencyAuthController::class, 'login']);
});

// Route::get('/', HomeController::class);
Route::get('/create', [PhotoController::class, 'create'])->name('upload');
Route::post('/create', [PhotoController::class, 'store']);
