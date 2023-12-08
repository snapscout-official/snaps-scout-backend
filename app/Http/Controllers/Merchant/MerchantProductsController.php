<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\merchant\AddSpecRequest;
use App\Http\Requests\merchant\StoreMerchantProductRequest;
use App\Models\MerchantProduct;
use Illuminate\Http\Client\Request;

class MerchantProductsController extends Controller
{
    public function read(Request $request)
    {
        $merchant = $request->user()->merchant;
        $products = $merchant->products()->get();
        return response()->json([
            'message' => 'success',
            'data' => $products
        ]);
    }
    public function store(StoreMerchantProductRequest $request)
    {
        DB::beginTransaction();
        $merchant = $request->user()->merchant;
        $product = $merchant->products()->create([
            'product_name' => $request->product_name,
            'product_category' => $request->product_category,
            'is_available' => true,
            'price' => $request->price,
            'barcode' => $request->barcode,
        ]); 
        return response()->json([
            'message' => 'success',
            'data' => $product
        ]);
        DB::commit();
    }
    public function storeSpec(AddSpecRequest $request)
    {
            //update product specs
            $product = MerchantProduct::where('product_name', 'bla')->first();
            $specs = $product->specs;
            //append the specs
            foreach($request->specs as $key => $value)
            {
                $specs[$key] = $value;
            }
            $product->specs = $specs;
            $product->save();
        return response()->json([
            'message' => 'success',
            'data' => $product
        ]);
    }
}
