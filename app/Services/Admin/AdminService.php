<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\ParentCategory;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;

class AdminService
{
    public function loginAdmin(AdminLoginRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password'])))
        {
            return $request->expectsJson() ? response()->json([
                'authenticated' => false,
                'message' => 'credentials error',
            ]) : null; 
        }
        $user = User::where('email', $request->email)->first();

        return $request->expectsJson() ? response()->json([
            'authenticated' => true,
            'message' => 'Sucessfully authenticated',
            'admin' =>  $user,
            'accessToken' => $user->createToken('auth-token')->plainTextToken
        ]) : null;

    }
    public function createCategory(AdminRequest $request)
    {
        //if the user added a thirdCategory the subCategory and parentCategory should also be present
        //in order to link the relationships
        if ($request->filled('thirdCategory'))
        {
            $parentCategory = ParentCategory::where('parent_name', $request->parentName);
            //the method returns an model instance of the thirdCategory
            $thirdCategory = $parentCategory->createThirdCategory($request->secondCategory, $request->thirdCategory);
            if (!isset($thirdCategory))
            {
                return response()->json([
                    'message' => 'unsucessful third Category creation'
                ], 422);
            }
            return response()->json([
                'message' => 'sucessfully created third category',
                'thirdCategory' => $thirdCategory
            ], 200);
        }

        //user wants to create a secondCategory the parentcategory should be present
        //thirdCategory could be null
        else if ($request->filled('secondCategory'))
        {
            $parentCategory = ParentCategory::where('parent_name', $request->parentCategory);
            $subCategoryResult = $parentCategory->subCategories()->create([
                'sub_name' => $request->subCategory
            ]);
            if (!isset($subCategoryResult))
            {
                return response()->json([
                    'message' => 'unsucessful sub category creation'
                ], 422);
            }
            return response()->json([
                'message' => 'sucessfully created sub category',
                'subCategory' => $subCategoryResult
            ], 200);
        }

        //if parent category only created then the subCategory and thirdCategory is not needed only needs to
        //create the parentCategory
        else if ($request->filled('parentCategory'))
        {
            $parentCategory = ParentCategory::create([
                'parent_name' => $request->parentCategory,
            ]);
            if (!isset($parentCategory))
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
}