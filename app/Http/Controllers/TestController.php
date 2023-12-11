<?php

namespace App\Http\Controllers;

use App\Models\CategorizedDocument;
use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Models\MerchantProduct;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Query\Builder;
use Illuminate\Contracts\Cache\LockTimeoutException;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {

        // $merchantTest = new MerchantProduct([
        //     'product_name' => 'Shampoo',
        //     'quantity' => 20,
        //     'price' => 2000
        // ]);
        // $merchantTest->save();
        
        // return $merchantTest;
        //lock test
        // $lock = Cache::lock('test', 10);
        // try {
        //     $lock->block(5);
        //     $res = Cache::store('cache')->get('merchant_products');
        //     if(is_null($res))
        //     {
        //         $merchantProducts = MerchantProduct::all();                
        //         Cache::store('cache')->put('merchant_products', $merchantProducts, 600);
        //         return response()->json([
        //             'data' => $merchantProducts
        //         ]);
        //     }
        //     return response()->json([
        //         'data' => $res
        //     ]);
            
        // } catch (LockTimeoutException $err) {
        //     return response()->json([
        //         'error' => 'cannot make the action',
        //         'message' => $err->getMessage()
        //     ]);
        // }finally{
        //     $lock?->release();
        // }
        return response()->json([
            'data' => Cache::store('cache')->get('1products'),
        ]);
        //Cache the products specs with a name of productName . productId

        // $owner = new Owner([
        //     'name' => 'Gio Gonzales',
        //     'age' => 21,
        //     'company_name' => 'thefullstack',
        //     'position' => 'lead developer'
        // ]);
        // $owner->save();
        // // return response()->json([
        // //     'data' => $owner
        // // ]);
        // $owner = Owner::where('name', 'Gio Gonzales')->first();
        // $merchantProduct = MerchantProduct::first();
        // return $merchantProduct;
        // phpinfo();    
        // $merchantProducts = MerchantProduct::all();
        // dd($merchantProduct);
        // $products = $merchant->products;
       
    }
}
