<?php

namespace App\Actions\Product;

use App\Models\Spec;
use App\Models\Product;
use App\Exceptions\ProductException;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Resources\ProductSpecResource;

class GetSpecOfProduct
{
    use AsAction;

    public function handle(Product $product)
    {
        //just get a spec instance in order to access the values method relationship
        $spec = Spec::first();
        //first filter the specNames that has the productID column value of the product we desire to retrieve
        //next eagerload with a filter query also same as the first filter query
        if (is_null($spec)) {
            throw new ProductException("error retrieving specs on product {$product->product_name}");
        }
        $productSpecs = self::loadProductSpecs($spec, $product);
        return (new ProductSpecResource($product, $productSpecs));
    }

    public static function loadProductSpecs($spec, $product)
    {
        $productSpecs =  $spec->whereHas('values', function ($query) use ($product) {
            $query->where('product_id', $product->product_id);
        })->with(['values' => function ($query) use ($product) {
            $query->where('product_id', $product->product_id);
        }])->get();
        return $productSpecs;
    }
}
