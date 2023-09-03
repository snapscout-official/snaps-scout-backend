<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminRequest;

class AdminController extends Controller
{
    public function __construct(private AdminService $adminService)
    {
        
    }
    public function login(AdminLoginRequest $request)
    {
        return $this->adminService->loginAdmin($request);
    }
    public function store(AdminRequest $request)
    {
        return $this->adminService->postCategory($request);
    }
    public function create()
    {
        return $this->adminService->returnData();
    }
}
