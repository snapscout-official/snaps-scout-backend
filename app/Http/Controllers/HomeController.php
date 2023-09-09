<?php

namespace App\Http\Controllers;

use App\Models\ParentCategory;
use App\Models\SubCategory;
use App\Models\ThirdCategory;

class HomeController extends Controller
{
    public function __invoke()
    {
        
        $forSelect = [];
        $data = ParentCategory::with('subCategories.thirdCategories')->get();
        $parentCategories = ParentCategory::all();
        $subCategories = SubCategory::all();
        
        // dd($data);        
        return response()->json([
            'data' => $data,
        ]);

           
    }
}

