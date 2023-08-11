<?php

namespace App\Http\Controllers\Merchant;

use App\Services\AuthService;
use App\Http\Requests\merchant\AuthRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\merchant\MerchantAuthRequest;


class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        
        
        return (new AuthService())->authenticateRegisterMerchant($request);
    }


    public function login(MerchantAuthRequest $request)
    {

       return (new AuthService())->authenticateLoginMerchant($request);
    }
}
