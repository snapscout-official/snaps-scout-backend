<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\CategoryRequest;
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
    public function destroyThird(int $thirdId, CategoryRequest $request)
    {
        return $this->categoryService->deleteThirdCategory($thirdId, $request);
    }
    public function destroySub(int $subId)
    {
        return $this->categoryService->deleteSubCategory($subId);
    }
    public function destroyParent(int $parentId)
    {
        return $this->categoryService->deleteParentCategory($parentId);
    }
}
