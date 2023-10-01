<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\StoreProductRequest;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\SubCategory;
use App\Services\Products\ProductService;


class ProductsController extends Controller
{
    public function __construct(private ProductService $productService)
    {
        
    }
    public function read()
    {
        $subCategories = SubCategory::with('products')->get();
        $parentCategories = ParentCategory::with('subCategories.products')->get();
        return response()->json([
            'ParentProducts' => $parentCategories
        ]);
    
    }
    public function retrieve()
    {
        return response()->json([
            'products' => Product::with('specs')->get()
        ]);
    }
    public function store(StoreProductRequest $request)
    {
        return $this->productService->storeProduct($request);
    }
    
}
