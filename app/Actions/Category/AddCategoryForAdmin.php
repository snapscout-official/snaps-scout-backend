<?php

namespace App\Actions\Category;

use App\Models\SubCategory;
use App\Events\CategoryAdded;
use App\Models\ParentCategory;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Admin\AdminRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class AddCategoryForAdmin
{
    use AsAction;

    public function handle(AdminRequest $request)
    {
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
            event(new CategoryAdded());
            //if the creation is sucessful then return the important fields
            //CHANGE CACHE AFTER INSERTION
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
            event(new CategoryAdded());
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
            event(new CategoryAdded());
            
            //if creation is success, return important fields
            return response()->json([
                'message' => 'sucessfully created parent category',
                'parentCategory' => $parentCategory
            ]);
        }
    }
}