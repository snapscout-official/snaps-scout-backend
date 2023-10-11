<?php

namespace App\Actions\Authentication;

use App\Events\TestEvent;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginSuperAdmin
{
    use AsAction;
    
    public function handle()
    {
        event(new TestEvent());
        return "Hello world";
    }
}