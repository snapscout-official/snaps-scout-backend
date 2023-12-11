<?php

use App\Events\PasswordReset;
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
use App\Http\Controllers\Agency\DocumentController;
use App\Http\Controllers\Merchant\AuthController;
use App\Http\Controllers\Merchant\MerchantProductsController;
use App\Http\Controllers\ProductsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::prefix('agency')->group(function () {
    Route::post('/register', [AgencyAuthController::class, 'register']);
    Route::post('/login', [AgencyAuthController::class, 'login']);
});
Route::prefix('merchant')->group(function()
{
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::post('/login', [AdminController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    //merchant api's
    Route::group(['middleware' => ['role:merchant'], 'prefix' => 'merchant'], function(){
    Route::controller(MerchantProductsController::class)->group(function(){
            Route::post('/add-product', 'store');
            Route::post('/add-spec', 'storeSpec');
            Route::get('/products', 'read');
    });
});
    Route::middleware('role:merchant')->group(function () {
        Route::get('/merchant/{merchant}', function (Merchant $merchant) {
            Gate::authorize('view-merchant', $merchant);
            return response()->json([
                'AgencyUser' => auth()->user()->merchant
            ]);
        });
    });
    //agency api's
    Route::group(['middleware' => ['role:agency'], 'prefix' => 'agency'], function(){
        Route::get('/agency', function () {
            return response()->json([
                'agencyUser' => auth()->user()->agency
            ]);
        });
        Route::controller(DocumentController::class)->group(function () {
            Route::post('/upload/document', 'upload');
            Route::post('/categorize/document', 'categorize');
            });
        Route::get('/products', [ProductsController::class, 'read']);
    });

    Route::group(['middleware' => ['role:super_admin', 'throttle:api'], 'prefix' => 'admin'], function () {
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/create-category', 'create');
            Route::post('/create-category',  'store');
            Route::delete('/third-category/{thirdId}', 'destroyThird');
            Route::delete('/sub-category/{subId}', 'destroySub');
            Route::delete('/parent-category/{parentId}', 'destroyParent');
        });

        Route::controller(ProductsController::class)->group(function () {
            Route::get('/products', 'read');
            Route::post('/add-product', 'store');
            Route::delete('/product/{product}', 'destroy');
            Route::post('/add-spec/{product}', 'addSpecs')->missing(function (Request $request) {
                return $request->expectsJson() ? response()->json([
                    'error' => 'Product does not exist'
                ], 500) : 'product does not exist';
            });
            Route::get('/product-specs/{productWithSpecs}', 'getProductSpecs')
                    ->withoutMiddleware(['role:super_admin', 'auth:sanctum'])->middleware('admin');
            Route::delete('/product-spec/{product}/{spec}', 'deleteSpecValues')->name('delete');
            //this api route is for deleting a single spec value. For example if there are typos in adding a spec
            // then we have the ability to delete
            Route::delete('/product-spec/{product}/{spec}/{specValueId}', 'deleteSpecValue');
        });
        Route::post('/logout', function (Request $request) {
            $user = $request->user();
            $delete = $user->currentAccessToken()->delete();
            return $delete ? response()->json([
                'message' => 'successfully logged out the user'
            ]) : response()->json([
                'error' => 'error logging out user',
                'userFull' => $user->first_name . ' ' .  $user->last_name
            ]);
        });
    });


    Route::middleware('signed')->group(function () {
        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return response()->json([
                'verified' => true,
                'message' => 'Email Verified'
            ]);
        })->name('verification.verify');
    });

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    })->name('verification.send');
});

Route::middleware('guest')->group(function () {
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? response()->json(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    });
    Route::post('/reset-password', function (Request $request) {
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
            }
        );
        $user = User::where('email', $request->email);
        PasswordReset::dispatch($user);
        return $status === Password::PASSWORD_RESET
            ? response()->json(['status' =>  __($status)])
            : back()->withErrors(['email' => [__($status)]]);
    });
});
