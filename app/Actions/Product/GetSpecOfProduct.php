<?php

namespace App\Actions\Product;

use App\Models\Spec;
use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Resources\ProductSpecResource;
use Illuminate\Contracts\Database\Eloquent\Builder;

class GetSpecOfProduct
{
    use AsAction;

    public function handle(Product $product)
    {
        //just get a spec instance in order to access the values method relationship
        $spec = Spec::first();
        //first filter the specNames that has the productID column value of the product we desire to retrieve
        //next eagerload with a filter query also same as the first filter query
        $productSpecs = self::loadProductSpecs($spec, $product);
        return (new ProductSpecResource($product, $productSpecs));
    }

    public static function loadProductSpecs($spec, $product)
    {
        $productSpecs =  $spec->whereHas('values', function (Builder $query) use ($product) {
            $query->where('product_id', $product->product_id);
        })->with(['values' => function (Builder $query) use ($product) {
            $query->where('product_id', $product->product_id);
        }])->get();
        return $productSpecs;
    }
}
