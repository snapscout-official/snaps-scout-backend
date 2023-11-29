<?php

namespace App\Http\Controllers;


use App\Models\Merchant;
use App\Models\MerchantProduct;


use App\Models\ParentCategory;
use App\Models\Spec;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {

        $merchantTest = new MerchantProduct([
            'product_name' => 'Shampoo',
            'quantity' => 20,
            'price' => 2000
        ]);
        $merchantTest->save();
        
        return $merchantTest;

      
       

    }
}
