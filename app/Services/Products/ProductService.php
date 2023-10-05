<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ThirdCategory;
use App\Http\Requests\Products\StoreProductRequest;

class ProductService{
    public function storeProductWithThirdCategory(StoreProductRequest $request)
    {       
            $thirdCategory = ThirdCategory::find($request->thirdCategoryId);
            if (empty($thirdCategory))
            {
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
            ],201): $productCreated;
        }
        
    
    public function storeProductWithoutThirdCategory(StoreProductRequest $request)
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
    public function filterProducts($products):array
    {
        
        $filteredProducts = [];
        foreach($products as $product)
        {
            if ($product->thirdCategory === null)
            {
                $filteredProducts[$product->product_id] = [
                    'product' => $product, 
                    'thirdCategory' => null,
                    'subCategory' => $product->subCategory,
                ];
            }
            $filteredProducts[$product->product_id] = [
                'product' => $product,
                'thirdCategory' => $product->thirdCategory,
                'subCategory' => $product->subCategory
            ];
        }
        return $filteredProducts;

    }
   

    public function deleteProduct(int $productId)
    {
        
        if (Product::destroy($productId))
        {
            $products = Product::with(['thirdCategory', 'subCategory'])->get();
            $filteredProducts = $this->filterProducts($products);
            return response()->json([
            'products' => $filteredProducts,
            ]);    
        }
        return response()->json([
            'error' => 'Product Unsuccessfully deleted',
        ], 500);
        
        
    }
}