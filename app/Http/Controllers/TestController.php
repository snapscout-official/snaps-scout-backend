<?php

namespace App\Http\Controllers;

use App\Models\CategorizedDocument;
use App\Models\ParentCategory;
use App\Models\Spec;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        // return asset('storage/SnapScout.xlsx');
        return CategorizedDocument::first();
    }
}
