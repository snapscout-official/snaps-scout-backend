<?php

namespace App\Services\Categories;

use App\Models\SubCategory;
use App\Models\ParentCategory;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\ThirdCategory;
use Illuminate\Support\Facades\Log;

class CategoryService {
    public function createCategory(AdminRequest $request)
    {
        //the method checks first if the request has a thirdcategory field that is not null
        if ($request->filled('thirdCategory'))
        {
            //first retrieves the subCategory since if it has a thirdCategory then a subCategory field that is not null is also expected
            $subCategory = SubCategory::where('sub_name', $request->subCategory)->first();
            
            //creates the thirdcategory using the relationship in order to establish a foreign key on the thirdCategory
            $thirdCategoryResult = $subCategory->thirdCategories()->create([
                'third_name' => $request->thirdCategory,
            ]);
            //if creation is failure then return an api response with an error message
            if (is_null($thirdCategoryResult))
            {
                return response()->json([
                    'message' => 'unsucessful third Category creation'
                ], 422);
            }
            //if the creation is sucessful then return the important fields
            return response()->json([
                'message' => 'sucessfully created third category',
                'thirdCategory' => $thirdCategoryResult,
                'subCategory' => $subCategory,
                'parentCategory' => $subCategory->parentCategory
            ], 200);
        }

        //if thirdCategory is null then it checks if it has a subCategory
        else if ($request->filled('subCategory'))
        {
            //creates subCategory using the parentCategory in order to establish relationship
            $parentCategory = ParentCategory::where('parent_name', $request->parentCategory)->first();
            $subCategoryResult = $parentCategory->subCategories()->create([
                'sub_name' => $request->subCategory 
            ]);
            //if creation has a failure then return error message
            if (is_null($subCategoryResult))
            {
                return response()->json([
                    'message' => 'unsucessful sub category creation'
                ], 422);
            }
            //for success, return important fields
            return response()->json([
                'message' => 'sucessfully created sub category',
                'subCategory' => $subCategoryResult,
                'parentCategory' => $parentCategory,
            ], 200);
        }

        //if no third and sub then checks for parentCategory
        else if ($request->filled('parentCategory'))
        {
            //creates parentCategory
            $parentCategory = ParentCategory::create([
                'parent_name' => $request->parentCategory,
            ]);
            //if creation fails then return error message
            if (is_null($parentCategory))
            {
                return response()->json([
                    'message' => 'unsucessfully created parent category'
                ], 422);
            }
            //if creation is success, return important fields
            return response()->json([
                'message' => 'sucessfully created parent category',
                'parentCategory' => $parentCategory
            ]);
        }
    }
    //service method that returns all the category data with its associated relationship
    public function returnData()
    {
        //retrieves the parentCategory with its subCategories and for each of its subCategories, gets their thirdCategory
        $data = ParentCategory::with('subCategories.thirdCategories')->get();
        return response()->json([
            'categories' => $data,
        ]);
    }
    public function deleteThirdCategory( int $categoryId)
    {
        //get the category type base on the classname of the request
        if (ThirdCategory::destroy($categoryId))
        {
            return response()->json([
                'message' => "Category successfully deleted"
            ]);
        }
        return response()->json(
            [
                'error' => "Third Category id {$categoryId} has error deleting"
            ]
        );

    }
    public function deleteSubCategory(int $categoryId)
    {
        if (SubCategory::destroy($categoryId))
        {
            return response()->json(
                [
                    'message' => "Category successfully deleted"
                ]
            );
        }
        return response()->json(
            [
                'error' => "Sub Category id {$categoryId} has error deleting"
            ]
        );
    }
    public function deleteParentCategory(int $categoryId)
    {
        if (ParentCategory::destroy($categoryId))
        {
            return response()->json(
                [
                    'message' => "Category successfully deleted"
                ]
            );
        }
        return response()->json(
            [
                'error' => "Parent Category id {$categoryId} has error deleting"
            ]
        );
    }
}