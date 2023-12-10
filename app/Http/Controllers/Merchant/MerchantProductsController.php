<?php

namespace App\Http\Controllers\Merchant;

use App\Exceptions\MerchantProductException;
use Illuminate\Http\Request;
use App\Models\MerchantProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\merchant\AddSpecRequest;
use App\Http\Requests\merchant\StoreMerchantProductRequest;

class MerchantProductsController extends Controller
{
    public function read(Request $request)
    {
        $merchant = $request->user()->merchant;
        $products = $merchant->products()->get();
        return response()->json([
            'message' => 'success product retrieval',
            'data' => $products,
            'total_products' => count($products),
        ]);
    }
    public function store(StoreMerchantProductRequest $request)
    {
        DB::beginTransaction();
        $merchant = $request->merchant();
        $product = $merchant->products()->create([
            'product_name' => $request->product_name,
            'product_category' => $request->product_category,
            'is_available' => true,
            'price' => $request->price,
            'barcode' => $request->barcode,
        ]); 
        DB::commit();
        return response()->json([
            'message' => "successfully added product {$product->product_name}",
            'data' => $product
        ]);
    }
    public function storeSpec(AddSpecRequest $request)
    {
            //update product specs
            $product = MerchantProduct::where('product_name', $request->product_name)->first();
            if (is_null($product))
            {
                throw new MerchantProductException('product cannot be found');
            }
            $specs = $product->specs;
            //append the specs
            foreach($request->specs as $key => $value)
            {
                $specs[$key] = $value;
            }
            $product->specs = $specs;
            $product->save();
        return response()->json([
            'message' => "successfully added specs to product {$request->product_name}",
            'data' => $product
        ]);
    }
}
