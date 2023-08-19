<?php

namespace App\Http\Requests\merchant;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRegisterRequest extends FormRequest
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
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'dateOfBirth' => 'required|date',
            'gender' => 'required',
            'phoneNumber' => 'required|unique:users,phone_number',
            'street' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'building' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'businessName' => 'required',
            'position' => 'required',
            'tinNumber' => 'required|unique:users,tin_number',
            'category' => 'required',
            'philgeps' => 'required',

        ];
    }
}
