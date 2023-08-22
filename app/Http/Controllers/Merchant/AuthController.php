<?php

namespace App\Http\Controllers\Merchant;

use App\Services\AuthService;

use App\Http\Controllers\Controller;
use App\Http\Requests\merchant\MerchantRegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        
    }
    
    public function register(MerchantRegisterRequest $request)
    {
        
        
        return $this->authService->authenticateRegisterMerchant($request);
    }

    public function login(Request $request)
    {

       return $this->authService->authenticateLoginMerchant($request);
    }
}
