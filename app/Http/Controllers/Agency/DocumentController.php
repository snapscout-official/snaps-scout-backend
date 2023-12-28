<?php

namespace App\Http\Controllers\Agency;

use Illuminate\Http\Request;
use App\Models\AgencyDocument;
use App\Events\DocumentCategorized;
use App\Models\CategorizedDocument;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Actions\Agency\StoreAgencyDocument;
use App\Exceptions\DocumentCategorizeException;
use App\Services\CategorizeDocumentService;
use App\Jobs\Documents\StoreCategorizedData;
use App\Http\Requests\Agency\AgencyDocumentRequest;
use App\Http\Requests\Agency\CategorizeDocumentRequest;

class DocumentController extends Controller
{
    
    public function categorize(CategorizeDocumentRequest $request, CategorizeDocumentService $categorizeService)
    {
        $documentModel =  $request->documentModel();
        if ($documentModel->is_categorized){
            throw new DocumentCategorizeException("The document is already categorized:{$documentModel->document_name}");   
        }
        $data = $categorizeService->categorizeDocument($request);
        [$categorized, $totalProducts] = $data;       
        $categorizedData = [
            'total_products' => $totalProducts,
            'document_id' => $documentModel->id,
            'agency_id' => $request->user()->id,
            'categories_number' => count($categorized),
            'data' => $categorized
        ];
        //a job is dispatched for storing the categorized document in to the database
        // dd("Test");
        StoreCategorizedData::dispatch($categorizedData, $documentModel);
        //event that will cache the categorized data into redis
        //Note: issue is if ever there is an redis error, the categorized document is stored in db but it wont be cached
        // When retrieving the data on the cache for get api there might be error that will happen if it was not cached.
        
        DocumentCategorized::dispatch($categorizedData);
        
        $categorizedData['message'] = 'successfully categorizing data';
        return response()->json($categorizedData, 201);
    }
    public function upload(AgencyDocumentRequest $request, CategorizeDocumentService $documentService)
    {
        if (!$request->fileIsValid()) {
            return response()->json([
                'error' => 'file format is invalid'
            ], 422);
        }
        $errors = $documentService->checkDocumentBeforeUpload($request);
        if (count($errors) != 0){
            return response()->json([
                'message' => 'The document does not adhere to the rule',
                'errorRows' => $errors
            ], 422);
        }
        return StoreAgencyDocument::run($request);
    }
    public function read(AgencyDocument $document)
    {
        //the document to be retrieved data is already categorized
        if ($document->is_categorized)
        {
            //gets the categorized document if it is already in the cache
            $categorizedDocument = Cache::store('cache')->get("{$document->id}products");
            //if not in the cache then cache the retrieved data
            if (is_null($categorizedDocument))
            {
                $categorizedDocument =  CategorizedDocument::where('document_id', $document->id)->first();
                //does have conflict since we passed a model
                DocumentCategorized::dispatch($categorizedDocument);
            }
            return response()->json([
                'message' => 'success',
                'data' => $categorizedDocument
            ]);
        }
        return response()->json([
            'message' => 'document is not yet categorized',
            'data' => null
        ]);
    }
    public function readDocuments( Request $request)
    {
        $agency = $request->user()->agency;
        $documents = $agency->documents;
        return response()->json([
            'message' => "agency {$agency->agency_name} documents successfully retrieved",
            'data' => $documents
        ]);
    }
}
