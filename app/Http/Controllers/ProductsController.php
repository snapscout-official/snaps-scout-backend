<?php

namespace App\Http\Controllers;

use App\Actions\Product\AddSpecValueToProduct;
use App\Actions\Product\DeleteProduct;
use App\Actions\Product\DeleteProductSpecValue;
use App\Actions\Product\GetSpecOfProduct;
use App\Actions\Product\StoreProductsWithOutThirdCategory;
use App\Actions\Product\StoreProductsWithThirdCategory;
use App\Models\Product;
use App\Http\Requests\AddSpecRequest;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{
    public function read()
    {
        $products = Product::with(['thirdCategory', 'subCategory'])->get();
        return ProductResource::collection($products);
    }

    public function retrieve()
    {
        return response()->json([
            'products' => Product::with('specs')->get()
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        if ($request->filled('thirdCategoryId')) {
            return StoreProductsWithThirdCategory::run($request);
        }
        return StoreProductsWithOutThirdCategory::run($request);
    }
    public function destroy(int $productId)
    {
        return DeleteProduct::run($productId);
    }
    public function addSpecs(Product $product, AddSpecRequest $request)
    {
        return AddSpecValueToProduct::run($product, $request);
    }
    public function getProductSpecs(Product $product)
    {
        return GetSpecOfProduct::run($product);
    }
    public function deleteSpec(Product $product, int $specId)
    {
        return DeleteProductSpecValue::run($product, $specId);
    }
}
