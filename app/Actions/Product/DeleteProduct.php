<?php

namespace App\Actions\Product;

use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteProduct
{
    use AsAction;

    public function handle(int $productId)
    {
        if (Product::destroy($productId)) {
            return response()->json([
                'message' => 'successfully deleted the product'
            ]);
        }
        return response()->json([
            'error' => 'product Unsuccessfully deleted',
        ], 400);
    }
}
