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
        if ($request->filled('thirdCategory'))
        {
            $parentCategory = ParentCategory::where('parent_name', $request->parentName);
        //    $parentCategory->createThirdCategory($request->secondCategory, $request->thirdCategory);
        }
        else if ($request->filled('secondCategory'))
        {
            $parentCategory = ParentCategory::where('parent_name', $request->parentCategory);
            $parentCategory->subCategories->create([
                'sub_name' => $request->subCategory
            ]);
        }
        else if ($request->filled('parentCategory'))
        {
            $parentCategory = ParentCategory::create([
                'parent_name' => $request->parentCategory,
            ]);
            if (!$parentCategory)
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