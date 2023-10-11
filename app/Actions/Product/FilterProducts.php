<?php

namespace App\Actions\Product;

use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class FilterProducts
{
    use AsAction;

    public function handle(Collection $products):array
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
}