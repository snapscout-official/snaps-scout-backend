<?php

namespace App\Http\Requests\Agency;

use App\Imports\SecondSheetImport;
use Illuminate\Validation\Rules\File;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Foundation\Http\FormRequest;

class AgencyDocumentRequest extends FormRequest
{
    public $headings;
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
            'document' => ['required', 'file', File::types(['csv', 'xlsx'])],

        ];
    }
    //create a method that checks if the file format or the structure of the file is good. If not then return an error
    //indicating that there is something wrong with the uploaded file
    public function fileIsValid()
    {
        $this->headings = (new HeadingRowImport(SecondSheetImport::HEADER))->toArray($this->file('document'))[1][0];
        //checks if it exists on the excel header and should correspond to it
        if (in_array('general_description', $this->headings) && in_array('quantitysize', $this->headings)  && in_array('unit_of_measure', $this->headings)) {
            return true;
        }
        return false;
    }
}
