<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\ThirdCategory;
use App\Models\ParentCategory;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __invoke()
    {
        DB::beginTransaction();
        $parentCategory = ParentCategory::factory()->count(10)->create();
        $subCategory = SubCategory::factory()->count(30)->create();
        $thirdCategory = ThirdCategory::factory()->count(40)->create();
        $categories = ParentCategory::with('subCategories.thirdCategories')->get();
        // dd($categories);
        
        // $subCategories = [];
        // foreach($categories as $key => $category)
        // {
                
        //     $subCategories[$key] = Arr::flatten($category->subCategories); 

        // }
        Product::factory()->count(20)->create();
        $products = Product::with(['thirdCategory', 'subCategory'])->get();
        foreach($products as $key => $product)
        {
            if ($product->thirdCategory === null)
            {
                // dump($product->subCategory);
            }    
        }
        dd($products);
        DB::rollBack();
           
    }
}

