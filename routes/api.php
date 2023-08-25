<?php

use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Agency\AgencyAuthController;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Notification;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function()
{
    Route::middleware('role:merchant')->group(function(){
        Route::get('/merchant/{merchant}', function(Merchant $merchant)
        {
            Gate::authorize('view-merchant', $merchant);
                return response()->json([
                    'AgencyUser' => auth()->user()->merchant
                ]);
            
        });
    });

    Route::middleware('role:agency')->group(function()
    {
        Route::get('/agency',function()
        {
        // Gate::authorize('view-agency');
            return response()->json([
                'agencyUser' => auth()->user()->agency
            ]);
        });
    });

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return response()->json([
            'verified' => true,
            'message' => 'Email Verified'
        ]);
    })->middleware('signed')->name('verification.verify');


    Route::post('/email/verification-notification', function(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        //return to something
    })->name('verification.send');
    
});


Route::apiResource('test', TestController::class);
// Route::get('/test', TestController::class);
Route::prefix('agency')->group(function()
{
    Route::post('/register', [AgencyAuthController::class, 'register']);
    Route::post('/login', [AgencyAuthController::class, 'login']);
});

Route::post('/superadmin/');
