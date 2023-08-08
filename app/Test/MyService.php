<?php

namespace App\Test;

use Illuminate\Support\Facades\Facade;

class MyService extends Facade
{
    public function spit()
    {
        echo 'Myservice';
    }
}