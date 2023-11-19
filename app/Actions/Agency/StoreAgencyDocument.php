<?php

namespace App\Actions\Agency;

use App\Http\Requests\Agency\AgencyDocumentRequest;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreAgencyDocument
{
    use AsAction;
    public function handle(AgencyDocumentRequest $request)
    {
        //the document name will be its originaldocument name plus the id of the agency
        $file = $request->file('document');
        $fileName = explode('.', $file->getClientOriginalName())[0] . '-' .  $request->user()->id;
        $fileModifiedOriginalName = $fileName . '.' . $file->getClientOriginalExtension();
        $request->file('document')->storeAs('public', $fileModifiedOriginalName, 'local');
        $agencyModel = $request->user()->agency;
        $documentModel = $agencyModel->documents()->create([
            'document_name' => $fileModifiedOriginalName,
            'is_categorized' => false
        ]);
        return response()->json([
            'message' => 'success',
            'documentStored' => $fileModifiedOriginalName,
            'documentModel' => $documentModel
        ]);
    }
}
