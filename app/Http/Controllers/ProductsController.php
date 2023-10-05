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
        $products = Product::with(['thirdCategory', 'subCategory'])->get();
        $filteredProducts = $this->productService->filterProducts($products);
        return response()->json([
            'products' => $filteredProducts,

        
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
        if ($request->filled('thirdCategoryId'))
        {
            return $this->productService->storeProductWithThirdCategory($request);
        }
        return $this->productService->storeProductWithoutThirdCategory($request);
    }
    
}
