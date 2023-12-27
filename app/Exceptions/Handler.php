<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {

        $this->renderable(function (AuthenticationException $e, Request $request) {
            return $request->expectsJson() ? response()->json([
                'error' => 'Unauthenticated',
            ]) : redirect()->guest($e->redirectTo() ?? route('login'));
        });
        $this->renderable(function (MerchantProductException $e, Request $request)
        {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        });
        
    }
}
