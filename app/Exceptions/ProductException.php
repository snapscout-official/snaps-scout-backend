<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;


class ProductException extends Exception
{
    public function __construct(string $message)
    {
        $this->message = $message;
    }
    public function render(Request $request)
    {
        return $request->expectsJson() ? $request->json([
            'error' => $this->getMessage(),
        ], 400) : $this->message;
    }
}
