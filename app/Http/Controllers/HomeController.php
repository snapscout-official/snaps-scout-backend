<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        
    // $date = Carbon::createFromFormat('F j, Y', 'June 11, 2002')->format('Y-m-d');
    // dd($date);
        //     $merchant = Merchant::with(['user', 'location'])->first();
    //   dd($merchant);
    //     dump($merchantFirstName);
    //    dump($merchant->user->first_name);
    //    dump($merchant->user->last_name);
    //    dump($merchant->business_name);
    //    echo 'MerchantID : ' . $merchant->merchant_id . '<br>';
    //    echo 'UserId : ' . $merchant->user->id . '<br>';
    //    echo 'MerchantCountry: ' . $merchant->location->country;
    }
}
