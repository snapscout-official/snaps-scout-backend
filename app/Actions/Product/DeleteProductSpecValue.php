<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Models\SpecValue;
use Illuminate\Log\Logger;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteProductSpecValue
{
    use AsAction;

    public function handle(Product $product, int $specId)
    {
        $result = $product->specs()->detach($specId);
        if ($result <= 0) {
            return response()->json([
                'error' => "error deleting a spec on product {$product->product_name}",
            ]);
        }
        return response()->json([
            'message' => "spec on product {$product->product_name} has been deleted",
        ]);
    }
}
