<?php

namespace App\Http\Requests\Backend\Vendors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVendorsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // ================================== EDITED BY: RAGHAD ==================================
    public function rules()
    {
        $statusArray = [1 ,2]; // 1 => Active, 2 => Inactive
        $countriesArray = range(1, 250); // Each number represent a contry and its data
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            'country_phone_id' => ['nullable','numeric',Rule::in($countriesArray)],
            'status' => ['required','numeric','integer',Rule::in($statusArray)],
            'balance' => 'required|numeric|min:0'
        ];
        if (isset($this->phone)) {
            $rules['country_phone_id'] = ['required', 'numeric','integer', Rule::in($countriesArray)];
           $phoneValue = $this->input('phone');
           $phoneLength = strlen(preg_replace('/\D/', '', $phoneValue )); // Remove non-numeric characters
            if ($phoneLength < 9 || $phoneLength > 15) {
                $rules['phone_not_valid'] = 'required';
            }
        }
        if (isset($this->country_phone_id)) {
            $rules['country_phone_id'] = ['numeric','integer', Rule::in($countriesArray)];
            $rules['phone'] = 'required';
        }
        return $rules;
    }
    public function messages(){
        return [
            'name_ar' => 'Name AR is required',
            'name_en' => 'Name EN is required',

            'email.email' => 'Email is not valid',

            'phone.required' => 'Phone is required',
            'phone.numeric' => 'Phone must be a number',
            'phone_not_valid.required' => 'Phone is not valid',

            'country_phone_id.required' => 'Country phone code is required',
            'country_phone_id.numeric' => 'Country phone code must be a number',
            'country_phone_id.integer' => 'Country phone code must be an iteger',
            'country_phone_id.in' => 'Country phone code is not valid',

            'status.required' => 'Status is required',
            'status.numeric' => 'Status must be a number',
            'status.integer' => 'Status must be an integer',
            'status.in' => 'Status is not valid',

            'balance.required' => 'Balance is required',
            'balance.numeric' => 'Balance must be a number',
            'balance.min' => 'Balance value must be at least 0',


        ];
    }
}
