<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use Carbon\Carbon;
use App\Models\Spec;
use App\Models\User;
use App\Models\Agency;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Merchant;
use App\Mail\MyTestEmail;
use App\Models\ParentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function __invoke()
    {
        // $parents = ParentCategory::all();
        $data = ParentCategory::with('subCategories')->get();
        
        
        // foreach($parents as $parent)
        // {
        //     dump($parent->categoryData());
        // }
        return response()->json([
            'data' => $data
        ]);
            // return $data;
    }
}

