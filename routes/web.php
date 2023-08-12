<?php

use App\Models\User;
use App\Models\Agency;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Merchant\AuthController;
use App\Http\Controllers\Agency\AgencyAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('merchant' )->group(function(){
    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);
});

Route::prefix('agency')->group(function()
{
    Route::post('/register', [AgencyAuthController::class, 'register']);
});

Route::get('/', HomeController::class);

    // Route::get('/agency/{agency}', function(Agency $agency){
    //     $user = User::where('id', 15)->first();
    //     if (Gate::forUser($user)->allows('view-agency-info', $agency))
    //     {
    //         dd($agency);
    //     }
    // });
