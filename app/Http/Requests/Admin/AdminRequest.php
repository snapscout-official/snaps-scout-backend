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
            'parentCategory' => 'required|string',
            'secondCategory' => 'sometimes|required|string',
            'thirdCategory' => 'sometimes|required|string'
        ];
        if (!($this->filled('secondCategory') || $this->filled('thirdCategory')))
        {
            $rules['parentCategory'] = 'required|string|unique:parent_category,parent_id';
        }
        return $rules;
    }
}
