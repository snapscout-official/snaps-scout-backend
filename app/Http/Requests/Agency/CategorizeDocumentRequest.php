<?php

namespace App\Http\Requests\Agency;

use App\Imports\SecondSheetImport;
use App\Models\AgencyDocument;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class CategorizeDocumentRequest extends FormRequest
{
    
    public $documentModel;
    //if the document is already categorized then this api should not be accessed again for categorizing since it has been categorized
    public function authorize(): bool
    {
        
        return true;
    }
    public function rules(): array
    {
        return [
            'document_name' => ['required', 'string', 'exists:agency_document,document_name'],
        ];
    }
    public function getAgencyName()
    {
        return $this->user()->agency->agency_name;
    }
    public function getHeadings()
    {
        return (new HeadingRowImport(SecondSheetImport::HEADER))->toArray(Storage::path($this->document_name))[1][0];
    }
    public function documentModel()
    {
        return AgencyDocument::where('document_name', $this->document_name)->first();
    }
   
}
