<?php

namespace App\Services;

use App\Models\User;
use App\Http\Requests\Admin\AdminLoginRequest;
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
}