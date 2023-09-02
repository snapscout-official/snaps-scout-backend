<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function create():View
    {
        return view('photo.index');
    }
    
    public function store(Request $request)
    {
        $file = $request->file('image');
    }
}
