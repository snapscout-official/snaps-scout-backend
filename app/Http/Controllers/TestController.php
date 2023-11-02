<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Mail\MyTestEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        // return Excel::download(new CategoryExport, 'category.xlsx');
    }
}
