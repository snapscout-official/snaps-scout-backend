<?php

namespace App\Services;

use App\Models\User;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Models\Role;

class AdminService
{
    public function __construct()
    {
    }
    public function loginAdmin(AdminLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user->role_id !== Role::SUPERADMIN)
        {
            return $request->expectsJson() ? response()->json([
                'authenticated' => false,
                'message' => 'You are not authorized to login as admin'
            ], 401) : null;
        }
        
    }
}