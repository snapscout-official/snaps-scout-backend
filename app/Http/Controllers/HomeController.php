<?php

namespace App\Http\Controllers;

use App\Imports\TestImport;
use App\Models\SubCategory;
use App\Models\ThirdCategory;
use App\Models\ParentCategory;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class HomeController extends Controller
{
    public function __invoke()
    {
        // DB::beginTransaction();
        // $parentCategory = ParentCategory::factory()->count(10)->create();
        // $subCategory = SubCategory::factory()->count(30)->create();
        // $thirdCategory = ThirdCategory::factory()->count(40)->create();
        // $categories = ParentCategory::with('subCategories.thirdCategories')->get();
        // // dd($categories);
        
        // // $subCategories = [];
        // // foreach($categories as $key => $category)
        // // {
                
        // //     $subCategories[$key] = Arr::flatten($category->subCategories); 

        // // }
        // Product::factory()->count(20)->create();
        // $products = Product::with(['thirdCategory', 'subCategory'])->get();
        // foreach($products as $key => $product)
        // {
        //     if ($product->thirdCategory === null)
        //     {
        //         // dump($product->subCategory);
        //     }    
        // }
        // dd($products);
        // DB::rollBack();
        
        $headings = (new HeadingRowImport(TestImport::HEADINGROW))->toArray(storage_path('app/public/SnapScout(2).xlsx'))[1];

        dump($headings = Arr::collapse($headings));
        $headings = array_flip($headings);
        // dump($headings[TestImport::GENERAL]);
        $data =  Excel::toArray(new TestImport, storage_path('app/public/SnapScout(2).xlsx'))[1];
        $data = array_slice($data, 1, count($data) - 1);
        dump($data);
        foreach($data as $product)
        {
        //   dump(explode(',', $product[TestImport::GENERAL]));
        }

        
    }
}

