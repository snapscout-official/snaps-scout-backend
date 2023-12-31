<?php

namespace App\Http\Requests\merchant;

use Illuminate\Foundation\Http\FormRequest;

class AddSpecRequest extends FormRequest
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
            'specs' => 'required|array',
            'product_name' => 'required|string'            
        ];
    }
    public function merchant()
    {
        return $this->user()->merchant;
    }
}
