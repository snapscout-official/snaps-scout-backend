<?php

namespace App\Http\Controllers;

use App\Models\ProposalDocument;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function create(): View
    {
        return view('photo.index');
    }

    public function store(Request $request)
    {

        $file = $request->file('image');
        $path = $request->image->storeAs('public/images', $file->getClientOriginalName());

        $document = ProposalDocument::create([
            'title' => $file->getClientOriginalName(),
            'size' => (string)$file->getSize(),
            'doc_agency' => auth()->user()->id
        ]);
        if (is_null($document)) {
            return response()->json([
                'message' => 'Error',

            ]);
        }

        return response()->json([
            'message' => "Success",
            'document' => $document
        ], 200);
    }
}
