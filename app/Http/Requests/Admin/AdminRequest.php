<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{

    public function authorize(): bool
    {
        //checks if the request has either one of this fields. If not then not authorized to proceed to the controller logic
        if ($this->filled('thirdCategory') || $this->filled('subCategory') || $this->filled('parentCategory'))
        {
            return true;
        }
        return true;
    }

    public function rules(): array
    {
        $rules = [];
        // if the thirdCategory is not null then the parent field and subCategory field is expected
        if ($this->filled('thirdCategory'))
        {
            //changes the rules for parentCategory to be sometimes
            $rules['parentCategory'] = 'sometimes';
            //subCategory should be present if thirdCategory is not null
            $rules['subCategory'] = 'required|string';
            //the thirdCategory name should be unique
            $rules['thirdCategory'] = 'required|unique:third_category,third_name';
        }
        //if no thirCategory is null and subCategory is not null then change the rules
        else if ($this->filled('subCategory'))
        {
            //thirdCategory will be sometimes since it wont be required
            $rules['thirdCategory'] = 'sometimes';
            //subCategory name should be unique and should also be a string
            $rules['subCategory'] = 'required|string|unique:sub_category,sub_name';
            //parentCategory is required when adding a new subCategory
            $rules['parentCategory'] = 'required|string';
        }
        //if thirdCat and subCat is null then checks if parentCategory is present
        else if ($this->filled('parentCategory'))
        {
            //if present then it should be unique and the thirdCat and subCat is not required since we are only adding the parentCategory
            $rules['parentCategory'] = 'required|string|unique:parent_category,parent_name';
            $rules['subCategory'] ='sometimes';
            $rules['thirdCategory'] = 'sometimes';  
        }
        return $rules;
    }
}
