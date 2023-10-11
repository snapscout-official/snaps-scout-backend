<?php

namespace App\Actions\Product;

use App\Models\SubCategory;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Requests\Products\StoreProductRequest;

class StoreProductsWithOutThirdCategory
{
    use AsAction;

    public function handle(StoreProductRequest $request)
    {
        $subCategory = SubCategory::find($request->subCategoryId);
        if (empty($subCategory))
        {
            return response()->json([
                'error' => 'Product unsucessfully stored',
            ]);
        }

        $productCreated = $subCategory->products()->create([
            'product_name' => $request->product_name,
            'description' => $request->description,
        ]);

       
        return response()->json([
            'message' => 'Successfully added the product',
            'subCategory' => $subCategory->sub_name,
            'product' => $productCreated
        ],201); 

    }
}