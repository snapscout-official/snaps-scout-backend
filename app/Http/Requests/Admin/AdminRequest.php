<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules =  [
            'parentCategory' => 'sometimes',
            'subCategory' => 'sometimes|required|string',
            'thirdCategory' => 'sometimes|required|string'
        ];
        if ($this->filled('thirdCategory'))
        {
            $rules['parentCategory'] = 'sometimes';
            $rules['thirdCategory'] = 'required|unique:third_category,third_name';
        }
        else if ($this->filled('subCategory'))
        {
            $rules['thirdCategory'] = 'sometimes';
            $rules['subCategory'] = 'required|unique:sub_category,sub_name';
            $rules['parentCategory'] = 'required|string';
        }
        else
        {
            $rules['parentCategory'] = 'required|string|unique:parent_category,parent_id';
            $rules['subCategory'] ='sometimes';
            $rules['thirdCategory'] = 'sometimes';
        }
        return $rules;
    }
}
