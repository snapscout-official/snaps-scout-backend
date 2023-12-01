<?php

namespace App\Actions\Product;

use App\Exceptions\ProductException;
use App\Models\Product;
use App\Models\Spec;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteOneSpecValue
{
    use AsAction;
    public function handle(Product $product, Spec $spec, int $specValueId)
    {
        $deletedCount = $spec->values()->detach([$specValueId]);
        if ($deletedCount <= 0 || $deletedCount != 1) {
            throw new ProductException("error deleting spec value on product {$product->product_name}");
        }
        return response()->json([
            'message' => "successfully deleted spec value on product {$product->product_name}"
        ]);
    }
}
