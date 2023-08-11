<?php

namespace App\Http\Controllers\Agency;

use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\AgencyRegister;

class AgencyAuthController extends Controller
{
    public function register(AgencyRegister $request)
    {
        
        return (new AuthService())->authenticateRegisterAgency($request);

    }
}
