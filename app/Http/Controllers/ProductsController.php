<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\AddSpecRequest;
use App\Actions\Product\DeleteProduct;
use App\Http\Resources\ProductResource;
use App\Actions\Product\GetSpecOfProduct;
use App\Actions\Product\AddSpecValueToProduct;
use App\Actions\Product\DeleteOneSpecValue;
use App\Actions\Product\DeleteProductSpecValues;
use App\Http\Requests\Products\StoreProductRequest;
use App\Actions\Product\StoreProductsWithThirdCategory;
use App\Actions\Product\StoreProductsWithOutThirdCategory;
use App\Models\Spec;

class ProductsController extends Controller
{
    public function read()
    {
        $products = Product::with(['thirdCategory', 'subCategory'])->get();
        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        if ($request->filled('thirdCategoryId')) {
            return StoreProductsWithThirdCategory::run($request);
        }
        return StoreProductsWithOutThirdCategory::run($request);
    }
    public function destroy(int $product)
    {
        return DeleteProduct::run($product);
    }
    public function addSpecs(Product $product, AddSpecRequest $request)
    {
        return AddSpecValueToProduct::run($product, $request);
    }
    public function getProductSpecs(Product $productWithSpecs)
    {
        return $productWithSpecs;
    }
    public function deleteSpecValues(Product $product, Spec $spec)
    {
        return DeleteProductSpecValues::run($product,  $spec);
    }
    public function deleteSpecValue(Product $product, Spec $spec, int $specValueId)
    {
        return DeleteOneSpecValue::run($product, $spec, $specValueId);
    }
}
