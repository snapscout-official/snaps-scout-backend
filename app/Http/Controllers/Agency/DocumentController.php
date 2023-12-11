<?php

namespace App\Http\Controllers\Agency;

use App\Actions\Agency\CategorizeDocumentData;
use App\Actions\Agency\StoreAgencyDocument;
use App\Events\DocumentCategorized;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\AgencyDocumentRequest;
use App\Http\Requests\Agency\CategorizeDocumentRequest;
use App\Jobs\Documents\StoreCategorizedData;

class DocumentController extends Controller
{
    public function categorize(CategorizeDocumentRequest $request)
    {

        $documentModel = $request->documentModel();
        $data = CategorizeDocumentData::run($request);
        [$categorized, $totalProducts] = $data;       
        $categorizedData = [
            'total_products' => $totalProducts,
            'document_id' => $documentModel->id,
            'agency_id' => $request->user()->id,
            'categories_number' => count($categorized),
            'data' => $categorized
        ];
        //a job is dispatched for storing the categorized document in to the database
        StoreCategorizedData::dispatch($categorizedData, $documentModel);
        //event that will cache the categorized data into redis
        //Note: issue is if ever there is an redis error, the categorized document is stored in db but it wont be cached
        // When retrieving the data on the cache for get api there might be error that will happen if it was not cached.
        DocumentCategorized::dispatch($categorizedData);
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
