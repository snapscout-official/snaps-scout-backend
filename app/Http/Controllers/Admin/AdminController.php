<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Authentication\LoginSuperAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;

class AdminController extends Controller
{
    public function login(AdminLoginRequest $request)
    {
        return LoginSuperAdmin::run($request);
    }
    
}
