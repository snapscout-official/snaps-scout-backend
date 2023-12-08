<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\merchant\StoreMerchantProductRequest;
use App\Models\MerchantProduct;
use Illuminate\Support\Facades\DB;

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
            'price' => $request->price,
            'bar_code' => $request->bar_code,
        ]);
        return response()->json([
            'message' => 'success',
            'data' => $product
        ]);


        DB::commit();
    }
}
