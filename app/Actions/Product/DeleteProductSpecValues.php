<?php

namespace App\Actions\Product;

use App\Exceptions\ProductException;
use App\Models\Product;
use App\Models\Spec;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteProductSpecValues
{
    use AsAction;

    public function handle(Product $product, Spec $spec)
    {
        if (empty($spec)) {
            throw new ProductException("error deleting spec id{$spec->code}");
        }
        $result = $spec->values()->wherePivot('product_id', $product->product_id)->detach();
        //if there is no deleted values then throw the exception
        if ($result <= 0) {
            throw new ProductException("error deleting a spec on product {$product->product_name}");
        }
        return response()->json([
            'message' => "spec on product {$product->product_name} has been deleted",
        ]);
    }
}
