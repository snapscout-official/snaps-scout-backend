<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Services\Categories\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
        
    }
    public function store( AdminRequest $request)
    {
       return $this->categoryService->createCategory($request);
    }  
    public function create()
    {
        return $this->categoryService->returnData();
    }
    public function destroyThird(int $thirdId)
    {
        return $this->categoryService->deleteCategory($thirdId, 'App\Models\ThirdCategory');
    }
    public function destroySub(int $subId)
    {
        return $this->categoryService->deleteCategory($subId, 'App\Models\SubCategory');
    }
    public function destroyParent(int $parentId)
    {
        return $this->categoryService->deleteCategory($parentId, 'App\Models\ParentCategory');
    }
}
