<?php

use App\Models\User;
use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
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

    Route::middleware(['role:super_admin'])->group(function()
    {
        Route::prefix('admin')->group(function(){
        
            Route::post('/create-category', [CategoryController::class, 'store']);
            Route::get('/create-category', [CategoryController::class, 'create']);
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

Route::middleware('guest')->group(function(){
    Route::get('/forgot-password', function(){
        return view('auth.forgot-password');
    });
    Route::post('/forgot-password', function(Request $request){
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        });
    
        // Route::get('/reset-password/{token}', function(string $token)
        // {
        //     return 
        // });
        Route::post('/reset-password', function(Request $request){
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
            ]);
         
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
         
                    $user->save();
         
                }
            );
         
            return $status === Password::PASSWORD_RESET
                        ? redirect()->route('login')->with('status', __($status))
                        : back()->withErrors(['email' => [__($status)]]);
        });
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

// Route::get()



