<?php

namespace App\Http\Requests\Agency;

use App\Imports\SecondSheetImport;
use App\Models\AgencyDocument;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class CategorizeDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'documentName' => ['required', 'string', 'exists:agency_document,document_name'],
        ];
    }
    public function getAgencyName()
    {
        return $this->user()->agency->agency_name;
    }
    public function getHeadings()
    {
        return (new HeadingRowImport(SecondSheetImport::HEADER))->toArray(Storage::path($this->documentName))[1][0];
    }
    public function documentModel()
    {
        return AgencyDocument::where('document_name', $this->documentName)->first();
    }
}
