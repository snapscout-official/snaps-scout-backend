<?php

namespace App\Http\Controllers\Agency;

use App\Actions\Agency\GetProducts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\GetProductsRequest;
use Illuminate\Http\Request;

class CategorizedProductController extends Controller
{
    //
    public function read(GetProductsRequest $request)
    {
        return GetProducts::run($request);
    }

}
