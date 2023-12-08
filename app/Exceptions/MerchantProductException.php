<?php

namespace App\Exceptions;

use Exception;

class MerchantProductException extends Exception
{
    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
