<?php

namespace App\Http\Controllers\Agency;

use App\Actions\Agency\CategorizeDocumentData;
use App\Actions\Agency\StoreAgencyDocument;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\AgencyDocumentRequest;

class DocumentController extends Controller
{
    public function categorize(AgencyDocumentRequest $request)
    {


        //should return the categorized data
        $data = CategorizeDocumentData::run($request);
        [$categorized, $totalProducts] = $data;
        return response()->json([
            'agencyName' => $request->getAgencyName(),
            'message' => 'document sucessfully categorized',
            'totalProducts' => $totalProducts,
            'categoriesNumber' => count($categorized),
            'data' => $categorized
        ], 201);
    }
    public function upload(AgencyDocumentRequest $request)
    {
        if (!$request->fileIsValid()) {
            return response()->json([
                'error' => 'file format is invalid'
            ], 422);
        }
        return StoreAgencyDocument::run($request);
    }
}
