<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\merchant\AddSpecRequest;
use App\Http\Requests\merchant\StoreMerchantProductRequest;
use App\Models\MerchantProduct;

class MerchantProductsController extends Controller
{
    public function read()
    {
        $merchantProducts = [];
        return response()->json([
            'message' => 'success',
            'data' => $merchantProducts
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
            'specs' => [],
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
            $product = MerchantProduct::where('product_name', $request->product_name)->first();
            $product->push('specs', $request->specs, true);
        return 'ok';
    }
}
