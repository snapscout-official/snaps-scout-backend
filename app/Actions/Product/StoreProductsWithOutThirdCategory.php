<?php

namespace App\Actions\Product;

use App\Exceptions\ProductCategoryException;
use App\Models\SubCategory;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Resources\Product\CreateProductResource;

class StoreProductsWithOutThirdCategory
{
    use AsAction;

    public function handle(StoreProductRequest $request)
    {
        $subCategory = SubCategory::find($request->subCategoryId);
        if (empty($subCategory)) {
            throw new ProductCategoryException("sub category id does not exist on the database");
        }

        $productCreated = $subCategory->products()->create([
            'product_name' => $request->product_name,
            'description' => $request->description,
        ]);
        if (is_null($productCreated)) {
            throw new ProductCategoryException("creating product {$request->product_name} results an error on the server");
        }
        return response()->json(new CreateProductResource($productCreated, $subCategory->sub_name), 201);
    }
}
