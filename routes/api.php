<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
    Route::middleware('merchant')->group(function(){
        Route::get('/merchant', function()
        {
            if (Gate::allows('view-merchant'))
            {
                return response()->json([
                    'AgencyUser' => auth()->user()->agency
                ]);
            }
            abort(403);
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



Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
