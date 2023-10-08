<?php

namespace App\Http\Controllers;

use App\Models\Spec;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddSpecRequest;
use App\Services\Products\ProductService;
use App\Http\Requests\Products\StoreProductRequest;

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
    public function destroy(int $productId)
    {
        
        return $this->productService->deleteProduct($productId);
        
    }
    public function addSpecs(Product $product,AddSpecRequest $request)
    {
        $specIds = [];
        foreach($request->specs as $spec)
        {
           $spec = Spec::firstOrCreate([
                'specs_name' => $spec['spec_name'],
            ]);
            $specIds[] = $spec->code;
        }
        
        $product->specs()->syncWithoutDetaching($specIds);
        return response()->json([
            'product' => $product,
            // 'specs' => $product->specs,
        ]);
    }
}
