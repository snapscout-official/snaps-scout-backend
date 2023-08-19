<?php

namespace App\Http\Controllers\Merchant;

use App\Services\AuthService;

use App\Http\Controllers\Controller;
use App\Http\Requests\merchant\MerchantRegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(MerchantRegisterRequest $request)
    {
        
        
        return (new AuthService())->authenticateRegisterMerchant($request);
    }


    public function login(Request $request)
    {

       return (new AuthService())->authenticateLoginMerchant($request);
    }
}
