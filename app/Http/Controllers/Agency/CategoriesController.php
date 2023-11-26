<?php
namespace App\Http\Controllers\Agency;

use App\Actions\Agency\GetProducts;
use App\Actions\Agency\StoreCategories;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\StoreCategoriesRequest;
use App\Actions\Agency\CacheProducts;
use App\Actions\Agency\MatchProducts;
use App\Http\Requests\Agency\GetProductsRequest;
use App\Http\Requests\Agency\MatchProduct;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    // public function store(StoreCategoriesRequest $request)
    // {
    //     return StoreCategories::run($request);
    // }

    public function read(GetProductsRequest $request)
    {
        return GetProducts::run($request);
    }

    // public function match(MatchProduct $request)
    // {
    //     return MatchProducts::run($request);
    // }
}