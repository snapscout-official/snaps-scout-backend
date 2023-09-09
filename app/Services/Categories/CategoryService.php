<?php

namespace App\Services\Categories;

use App\Models\SubCategory;
use App\Models\ParentCategory;
use App\Http\Requests\Admin\AdminRequest;

class CategoryService {
    public function createCategory(AdminRequest $request)
    {
        // return response()->json(['message' => 'Hello world']);
        if ($request->filled('thirdCategory'))
        {
            $subCategory = SubCategory::where('sub_name', $request->subCategory)->first();
            //the method returns an model instance of the thirdCategory
            $thirdCategoryResult = $subCategory->thirdCategories()->create([
                'third_name' => $request->thirdCategory,
            ]);
            // $thirdCategoryResult = $parentCategory->createThirdCategory($request->secondCategory, $request->thirdCategory);
            if (is_null($thirdCategoryResult))
            {
                return response()->json([
                    'message' => 'unsucessful third Category creation'
                ], 422);
            }
            return response()->json([
                'message' => 'sucessfully created third category',
                'thirdCategory' => $thirdCategoryResult,
                'subCategory' => $subCategory,
                'parentCategory' => $subCategory->parentCategory
            ], 200);
        }

        //user wants to create a secondCategory the parentcategory should be present
        //thirdCategory could be null
        else if ($request->filled('subCategory'))
        {
            $parentCategory = ParentCategory::where('parent_name', $request->parentCategory)->first();
            $subCategoryResult = $parentCategory->subCategories()->create([
                'sub_name' => $request->subCategory 
            ]);
            if (is_null($subCategoryResult))
            {
                return response()->json([
                    'message' => 'unsucessful sub category creation'
                ], 422);
            }
            return response()->json([
                'message' => 'sucessfully created sub category',
                'subCategory' => $subCategoryResult,
                'parentCategory' => $parentCategory,
            ], 200);
        }

        //if parent category only created then the subCategory and thirdCategory is not needed only needs to
        //create the parentCategory
        else if ($request->filled('parentCategory'))
        {
            $parentCategory = ParentCategory::create([
                'parent_name' => $request->parentCategory,
            ]);
            if (is_null($parentCategory))
            {
                return response()->json([
                    'message' => 'unsucessfully created parent category'
                ], 422);
            }
            return response()->json([
                'message' => 'sucessfully created parent category',
                'parentCategory' => $parentCategory
            ]);
        }
    }
    public function returnData()
    {
        $data = ParentCategory::with('subCategories.thirdCategories')->get();
        return response()->json([
            'categories' => $data,
        ]);
    }
}