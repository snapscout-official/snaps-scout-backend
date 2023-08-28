<?php

use App\Http\Controllers\Admin\AdminController;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agency\AgencyAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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


Route::prefix('agency')->group(function()
{
    Route::post('/register', [AgencyAuthController::class, 'register']);
    Route::post('/login', [AgencyAuthController::class, 'login']);
});

Route::prefix('super-admin')->group(function(){
    Route::middleware('admin')->group(function(){
        Route::post('/login', [AdminController::class, 'login']);
    });
});
