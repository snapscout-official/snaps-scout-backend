<?php

namespace App\Http\Controllers;

use App\Models\ParentCategory;
use App\Models\Spec;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        // gi load ang specs nga naay values which also nga ang values is belong sa matching product Id
        $spec = Spec::whereHas('values', function ($query) {
            $query->where('product_id', 1000);
        })->with(['values' => function ($query) {
            $query->where('product_id', 1000);
        }])->get();
        $res = Spec::whereHas('values', function ($query) {
            $query->where('product_id', 1000);
        })->delete();
        return $res;
    }
}
