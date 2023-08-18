<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        return response('Hello world')->cookie('name', 'value', 'minutes');
        // dd(gettype($res->is_admin));
    }
}
