<?php

namespace App\Http\Requests\merchant;

use Illuminate\Foundation\Http\FormRequest;

class StoreMerchantProductRequest extends FormRequest
{
 
    public function authorize(): bool
    {
        return true;
    }

  
    public function rules(): array
    {
        return [
            'product_name' => ['required', 'string', 'exists:products,product_name'],
            'product_category' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'price' => ['required'],
            'barcode' => 'required',
        ];
    }
    public function merchant()
    {
        return $this->user()->merchant;
    }
}
