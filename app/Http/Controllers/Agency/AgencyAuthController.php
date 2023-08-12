<?php

namespace App\Http\Controllers\Agency;

use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\AgencyLoginRequest;
use App\Http\Requests\Agency\AgencyRegister;

class AgencyAuthController extends Controller
{
    private AuthService $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    public function register(AgencyRegister $request)
    {
        
        return $this->authService->authenticateRegisterAgency($request);

    }

    public function login(AgencyLoginRequest $request)
    {
        return $this->authService->authenticateAgencyLogin($request);
    }
}
