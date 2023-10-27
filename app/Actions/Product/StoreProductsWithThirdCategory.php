<?php

namespace App\Actions\Product;

use App\Exceptions\ProductCategoryException;
use App\Models\ThirdCategory;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Resources\Product\CreateProductResource;

class StoreProductsWithThirdCategory
{
    use AsAction;
    public function handle(StoreProductRequest $request)
    {
        $thirdCategory = ThirdCategory::with('subCategory')->find($request->thirdCategoryId);
        if (empty($thirdCategory)) {
            throw new ProductCategoryException("third category id does not exist on the database");
        }

        $productCreated = $thirdCategory->products()->create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'sub_code' => $thirdCategory->subCategory->sub_id,
        ]);
        if (is_null($productCreated)) {
            throw new ProductCategoryException("creating product {$request->product_name} results an error on the server");
        }
        return $request->expectsJson() ? response()
            ->json(new CreateProductResource($productCreated, $thirdCategory->subCategory->sub_name, $thirdCategory->third_name), 201) : $productCreated;
    }
}
