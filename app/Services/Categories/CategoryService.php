<?php

namespace App\Services\Categories;

use App\Events\CategoryAdded;
use App\Events\CategoryDeleted;
use App\Models\SubCategory;
use Illuminate\Support\Arr;
use App\Models\ParentCategory;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Admin\AdminRequest;
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
    //service method that returns all the category data with its associated relationship
    public function returnData()
    {
        //retrieves the parentCategory with its subCategories and for each of its subCategories, gets their thirdCategory

        //note: REFACTOR! result should be paginated for efficiency issue
        
        $data = $this->cacheCategories();
        // Logger($data);
        return response()->json([
            'categories' => $data['data'],
            'subCategories' => $data['subCategories'],
           
        ], 200);
    }

    //general method for deleting of any type of category
    public function deleteCategory(int $categoryId, string $categoryType)
    {
        //parses the passed string since it is a fully qualified classname
        $parsedCategory = explode('\\', $categoryType);
        $categoryName = end($parsedCategory);

        //deletes the category base on its type
        //update the cache manually change to
        if ($categoryType::destroy($categoryId))
        {

            event(new CategoryDeleted());
            $data = $this->cacheCategories();

            return response()->json([
                'message' => "{$categoryName} of id {$categoryId} successfully deleted",
                'categories' => $data['data']
            ]);
        }
        return response()->json(
            [
                'error' => "{$categoryName} id {$categoryId} has error deleting"
            ]
        );
    }
    private function cacheCategories()
    {
        return Cache::remember('categories', 600, function()
        {
            $data = ParentCategory::with('subCategories.thirdCategories')->get();
            $subCategories = [];  
            foreach($data as $key => $parentCategory)
            {
                $subCategories[$key] = Arr::flatten($parentCategory->subCategories);
            }
            return ['data' => $data, 'subCategories' => $subCategories];
        });
        
    }

}