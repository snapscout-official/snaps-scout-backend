<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use Carbon\Carbon;
use App\Models\Spec;
use App\Models\User;
use App\Models\Agency;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Merchant;
use App\Mail\MyTestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function __invoke()
    {
        
   
        $user = User::find(6);
        event(new UserRegistered($user));
    
        

   
    

    }
}
