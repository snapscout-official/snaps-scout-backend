<?php

namespace App\Http\Controllers;

use App\Mail\MyTestEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        // $user = User::find();
        Mail::to('gio.gonzales@carsu.edu.ph')->send(new MyTestEmail());
    }

   
}
