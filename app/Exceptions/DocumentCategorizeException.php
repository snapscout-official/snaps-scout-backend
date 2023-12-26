<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class DocumentCategorizeException extends Exception
{
    public function __construct(string $message){
        $this->message = $message;
    }
    public function render(Request $request){
        [$message, $document] = explode(':', $this->message);
        $this->message = $message;
        return $request->expectsJson() ? response()->json([
            'error' => $this->getMessage(),
            'document' => $document,
        ], 400): $this->getMessage();
    }
}
