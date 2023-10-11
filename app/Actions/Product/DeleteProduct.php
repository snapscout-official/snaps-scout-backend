<?php

namespace App\Actions\Product;

use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class deleteProduct
{
    use AsAction;

    public function handle(int $productId)
    {
        if (Product::destroy($productId))
        {
            $products = Product::with(['thirdCategory', 'subCategory'])->get();
            $filteredProducts = FilterProducts::run($products);
            return response()->json([
            'products' => $filteredProducts,
            ]);    
        }
        return response()->json([
            'error' => 'Product Unsuccessfully deleted',
        ], 500);
        

    }
}