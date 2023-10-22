<?php

namespace App\Actions\Product;

use App\Models\ThirdCategory;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Requests\Products\StoreProductRequest;

class StoreProductsWithThirdCategory
{
    use AsAction;
    public function handle(StoreProductRequest $request)
    {
        $thirdCategory = ThirdCategory::find($request->thirdCategoryId);
        if (empty($thirdCategory)) {
            return response()->json([
                'error' => 'Product unsucessfully stored',
            ]);
        }

        $productCreated = $thirdCategory->products()->create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'sub_code' => $thirdCategory->subCategory->sub_id,
        ]);

        return $request->expectsJson() ? response()->json([
            'message' => 'Successfully added the product',
            'thirdCategory' => $thirdCategory->third_name,
            'product' => $productCreated,
            'subCategory' => $thirdCategory->sub_name,
        ], 201) : $productCreated;
    }
}
