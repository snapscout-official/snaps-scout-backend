<?php

namespace App\Http\Requests\Agency;

use Illuminate\Foundation\Http\FormRequest;

class AgencyRegister extends FormRequest
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
            'first_name' => 'required',
            'last_name'=>'required',
            'birth_date' => 'required',
            'tin_number' => 'required|unique:users,tin_number',
            'gender' =>'required',
            'phone_number' => 'required|unique:users,phone_number',
            'email'=>'required|email|unique:users,email',
            'password'=> 'required',
            'agency_name' => 'required',
            'building_name' => 'required',
            'street' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'agency_category_name' => 'required',
            'position' => 'required'
        ];
    }
}
