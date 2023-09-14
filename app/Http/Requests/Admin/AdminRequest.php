<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{

    public function authorize(): bool
    {
        //checks if the user requesting on the api is a superAdmin
        return $this->user()->role_id === Role::SUPERADMIN;
    }

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
        else if ($this->filled('parentCategory'))
        {
            $rules['parentCategory'] = 'required|string|unique:parent_category,parent_name';
            $rules['subCategory'] ='sometimes';
            $rules['thirdCategory'] = 'sometimes';  
        }
        return $rules;
    }
}
