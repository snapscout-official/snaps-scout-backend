<?php

namespace App\Http\Controllers\Agency;

use App\Actions\Agency\CategorizeDocumentData;
use App\Actions\Agency\StoreAgencyDocument;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\AgencyDocumentRequest;
use App\Http\Requests\Agency\CategorizeDocumentRequest;
use App\Jobs\Documents\StoreCategorizedData;

class DocumentController extends Controller
{
    public function categorize(CategorizeDocumentRequest $request)
    {


        //should return the categorized data
        $data = CategorizeDocumentData::run($request);
        [$categorized, $totalProducts] = $data;
        $categorizedData = [
            'total_products' => $totalProducts,
            'document_id' => $request->documentId(),
            'agency_id' => $request->user()->id,
            'categories_number' => count($categorized),
            'data' => $categorized
        ];
        //a job is dispatched for storing the categorized document in to the database
        StoreCategorizedData::dispatch($categorizedData);
        $categorizedData['message'] = 'successfully categorizing data';
        return response()->json($categorizedData, 201);
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
