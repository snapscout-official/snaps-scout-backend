<?php

namespace App\Actions\Category;

use App\Models\SubCategory;
use App\Events\CategoryAdded;
use App\Exceptions\ProductCategoryException;
use App\Models\ParentCategory;
use App\Http\Requests\Admin\AdminRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class AddCategoryForAdmin
{
    use AsAction;

    public function handle(AdminRequest $request)
    {

        if ($request->filled('thirdCategory')) {
            //first retrieves the subCategory since if it has a thirdCategory then a subCategory field that is not null is also expected
            $subCategory = SubCategory::where('sub_name', $request->subCategory)->first();
            if (is_null($subCategory)) {
                throw new ProductCategoryException("sub category not found when creating third category {$request->thirdCategory}");
            }
            //creates the thirdcategory using the relationship in order to establish a foreign key on the thirdCategory
            $thirdCategoryResult = $subCategory->thirdCategories()->create([
                'third_name' => $request->thirdCategory,
            ]);
            //if creation is failure then return an api response with an error message
            if (is_null($thirdCategoryResult)) {
                throw new ProductCategoryException('third category creation fails');
            }
            event(new CategoryAdded());
            //if the creation is sucessful then return the important fields
            return response()->json([
                'message' => 'sucessfully created third category',
                'thirdCategory' => $thirdCategoryResult,
                'subCategory' => $subCategory,
                'parentCategory' => $subCategory->parentCategory
            ], 200);
        }

        //if thirdCategory is null then it checks if it has a subCategory
        else if ($request->filled('subCategory')) {
            //creates subCategory using the parentCategory in order to establish relationship
            $parentCategory = ParentCategory::where('parent_name', $request->parentCategory)->first();
            if (is_null($parentCategory)) {
                throw new ProductCategoryException("parent category not found when creating sub category {$request->subCategory}");
            }
            $subCategoryResult = $parentCategory->subCategories()->create([
                'sub_name' => $request->subCategory
            ]);
            //if creation has a failure then return error message
            if (is_null($subCategoryResult)) {
                throw new ProductCategoryException("creating sub category {$request->subCategory} fails");
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
        else if ($request->filled('parentCategory')) {
            //creates parentCategory
            $parentCategory = ParentCategory::create([
                'parent_name' => $request->parentCategory,
            ]);
            //if creation fails then return error message
            if (is_null($parentCategory)) {
                throw new ProductCategoryException("creating parent category {$request->parentCategory} fails");
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
