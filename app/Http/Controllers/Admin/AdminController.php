<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Services\AdminService;

class AdminController extends Controller
{
    public function __construct(private AdminService $adminService)
    {
        
    }
    public function login(AdminLoginRequest $request)
    {
        return $this->adminService->loginAdmin($request);
    }
}
