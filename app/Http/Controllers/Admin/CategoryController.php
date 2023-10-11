<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Category\AddCategoryForAdmin;
use App\Actions\Category\DeleteCategoryForAdmin;
use App\Actions\Category\ReturnCategoryDataForAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Services\Categories\CategoryService;

class CategoryController extends Controller
{
    public function store(AdminRequest $request)
    {
       return AddCategoryForAdmin::run($request);
    }  
    public function create()
    {
        return ReturnCategoryDataForAdmin::run();
    }
    public function destroyThird(int $thirdId)
    {
        return DeleteCategoryForAdmin::run($thirdId, 'App\Models\ThirdCategory');
    }
    public function destroySub(int $subId)
    {
        return DeleteCategoryForAdmin::run($subId, 'App\Models\SubCategory');
    }
    public function destroyParent(int $parentId)
    {
        return DeleteCategoryForAdmin::run($parentId, 'App\Models\ParentCategory');
    }
}
