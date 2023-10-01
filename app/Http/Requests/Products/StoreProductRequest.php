<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $rules = [
            'description' => 'required|string',
            'subCategoryId' => 'required',
        ];
        //if thirdCategoryId is present then add rules for thirdCategory else then return the initial rules as the final rule for the product
        if ($this->filled('thirdCategoryId'))
        {
            $rules['thirdCategoryId'] = 'required';
            return $rules;
        }
        
        return $rules;
        
    }
}