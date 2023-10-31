<?php

namespace App\Actions\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Requests\Admin\AdminLoginRequest;

class LoginSuperAdmin
{
    use AsAction;

    public function handle(AdminLoginRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
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
