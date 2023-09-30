<?php

namespace App\Services\Products;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\ThirdCategory;
use App\Http\Requests\StoreProductRequest;

class ProductService{
    public function storeProduct(StoreProductRequest $request)
    {
        if ($request->filled('thirdCategoryId'))
        {
            $thirdCategory = ThirdCategory::find($request->thirdCategoryId);
            $productCreated = $thirdCategory->products()->create([
                'description' => $request->description,
            ]);
            if (empty($thirdCategory))
            {
                return response()->json([
                    'error' => 'Product unsucessfully stored',
                ]);
            }
            return $request->expectsJson() ? response()->json([
                'message' => 'Successfully added the product',
                'thirdCategory' => $thirdCategory->third_name,
                'product' => $productCreated
            ]): $productCreated;

        }
        $subCategory = SubCategory::find($request->subCategoryId);
        $productCreated = $subCategory->products()->create([
            'description' => $request->description,
        ]);
        if (empty($subCategory))
        {
            return response()->json([
                'error' => 'Product unsucessfully stored',
            ]);
        }
        return response()->json([
            'message' => 'Successfully added the product',
            'subCategory' => $subCategory->sub_name,
            'product' => $productCreated
        ]); 

    }

}