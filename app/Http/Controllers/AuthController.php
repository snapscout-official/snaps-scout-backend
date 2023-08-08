<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email',
            'name' =>'required',
            'password' => 'required'
        ]);
        if ($validate->fails())
        {
            return response()->json([
                'message' => "Error credentials"
            ]);
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if (Auth::attempt($request->only(['email', 'password'])))
        {
            return response()->json([
                'authenticated' => true,
                'User' => auth()->user(),
                'Message' => 'Successfully authenticated'
            ]);
        }
        
        return response()->json([
            'authenticated' => false,
            'Message' => 'Error authentication'
        ]);
    }
    public function login(Request $request)
    {

    }
}
