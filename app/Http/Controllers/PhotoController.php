<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function create():View
    {
        return view('photo.index');
    }
    
    public function store(Request $request)
    {
        // $file = $request->file('image');
    //    $request->image;
        // Storage::put('');
        // $path = $request->file('image')->store('public/images');
        Storage::put('public/images', $request->image);

        
    }
}
