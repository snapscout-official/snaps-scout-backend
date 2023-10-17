<?php

namespace App\Actions\Product;

use App\Http\Resources\ProductSpecResource;
use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSpecOfProduct
{
    use AsAction;

    public function handle(Product $product)
    {
        return (new ProductSpecResource($product));
    }
}
