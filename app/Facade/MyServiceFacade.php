<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class MyServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'myService';
    }
}