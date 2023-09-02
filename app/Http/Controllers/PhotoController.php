<?php

namespace App\Http\Controllers;

use App\Models\ProposalDocument;
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
        $file = $request->file('image');
        
        $document = ProposalDocument::create([
            'title' => $file->getClientOriginalName(),
            'size' => (string)$file->getSize(),
            'doc_agency' => auth()->user()->id
        ]);
        if (is_null($document))
        {
            return response()->json([
                'message' => 'Error',
                
            ]);
        }
        
        return response()->json([
            'message' => "Success",
            'document' => $document
        ],200);
        
        // dump(Storage::path('public/images/' . $request->file('image')->getClientOriginalName()));
        // return Storage::download('public/images/2Z5D2ZeUkFnO2J10PC2cXqJOw3KQepe1UTMmwSMR.png');
        // dd($request->file('image')->getClientOriginalName());

        
    }
}
