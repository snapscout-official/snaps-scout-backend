<?php

namespace App\Http\Controllers;

use App\Models\ParentCategory;

class HomeController extends Controller
{
    public function __invoke()
    {
        
        $data = ParentCategory::with(['subCategories', 'thirdCategories'])->get();
        
        return response()->json([
            'data' => $data
        ]);
           
    }
}

