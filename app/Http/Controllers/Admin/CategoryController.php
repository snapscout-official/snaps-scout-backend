<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Services\Categories\CategoryService;

class CategoryController extends Controller
{
    public function store(CategoryService $categoryService, AdminRequest $request)
    {
       return $categoryService->createCategory($request);
    }  
    public function create(CategoryService $categoryService)
    {
        return $categoryService->returnData();
    }
}
