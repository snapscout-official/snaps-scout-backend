<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class TestException extends Exception
{
    public function __construct()
    {
    }
    public function render(Request $request)
    {
        return $request->expectsJson() ? $request->json([
            'error' => $this->getMessage()
        ]) : 'test';
    }
}
