<?php

namespace App\Http\Controllers;


use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\Owner;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\Spec;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        //     $res = Cache::get('products');
        //     if(is_null($res))
        //     {
        //         $products = Product::all();                
        //         Cache::put('products',$products);
        //         return response()->json([
        //             'data' => $products
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
        
        $owner = Owner::where('name', 'Gio Gonzales')->first();
        $merchantProduct = MerchantProduct::first();
        return $merchantProduct;
        // phpinfo();
            // return MerchantProduct::all();
        // $owner->products()->create([
        //     'product_name' => 'testName2',
        //     'quantity' => 11,
        //     'description' => fake()->sentence(),
        //     'is_available' => true,
        //     'price' => 1010,
        //     'bar_code' => 1222131333,
        //     'specs' => [
        //         'RAM' => '3gb',
        //         'ROM' => '1tb',
        //         'GPU' => 'Nvidia RTX 4090'
        //     ],
        // ]);
        
        // $products =  $owner->products()->get();
        // foreach($products as $product)
        // {
        //     // dd($product->specs);
        //     // $product->push('specs', ['size' => '12inches']);
        //     dump($product->specs);
        // }
        // $str = 'offIcE sUpplies';
        // $str = strtolower($str);
        // dd(ucwords($str));
        // $uri = 'mongodb+srv://giogonzales:7PmwnIE378PsXckF@snap-scout-mongo.3sybvnx.mongodb.net/?retryWrites=true&w=majority';
        // // Specify Stable API version 1
        // $apiVersion = new ServerApi(ServerApi::V1);
        // // Create a new client and connect to the server
        // $client = new Client($uri, [], ['serverApi' => $apiVersion]);
        // try {
        //     // Send a ping to confirm a successful connection
        //     $client->selectDatabase('admin')->command(['ping' => 1]);
        //     echo "Pinged your deployment. You successfully connected to MongoDB!\n";
        // } catch (Exception $e) {
        //     printf($e->getMessage());
        // }
    }
}
