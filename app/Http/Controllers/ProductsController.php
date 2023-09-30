<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Products\ProductService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct(private ProductService $productService)
    {
        
    }
    public function retrieve()
    {
        return response()->json([
            'products' => Product::with('specs')->get()
        ]);
    }
    public function store()
    {
        
    }
    
}
