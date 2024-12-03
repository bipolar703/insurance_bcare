<?php

namespace App\Http\Requests\Backend\Customers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerFormRequest extends FormRequest
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
    // ===================================== Edited By Raghad =====================================
    public function rules()
    {
        $statusArray = [1, 2]; // 1 => Active, 2 => Inactive
        $countriesArray = range(1, 250); // Each number represent a contry and its data
        $rules = [
            'status' => ['required', 'numeric', 'integer', Rule::in($statusArray)],
            'name_ar' => 'required|unique:customers,name_ar,' . $this->id,
            'name_en' => 'required|unique:customers,name_en,' . $this->id,
            'email' => 'required|email|max:255|unique:customers,email,' . $this->id,
            'authorized_signatory' => 'nullable|max:250',
            'address' => 'nullable',
            'image' => 'nullable|mimes:png,jpg,jpeg,gif,webp',
            'country_phone_id' => ['required', 'numeric' ,'integer', Rule::in($countriesArray)],
        ];

        // Check the status value
        if (isset($this->status) && (($this->status != 1) && ($this->status != 2) )) {
            $rules['not_valid_status'] = 'required';
        }
        // Check the country phone id value
        if (isset($this->country_phone_id) && (($this->country_phone_id < 1) || $this->country_phone_id > 250)) {
            $rules['not_valid_country_phone_id'] = 'required';
        }
         // The phone and country_phone_id are unique
         $rules['phone'] = [ 'required', 'numeric', 'integer' ,'min:0',
         Rule::unique('customers')->ignore($this->id)->where(function ($query) {
             return $query->where('country_phone_id', request('country_phone_id'));
         }),
         'regex:/^[\d]{5,15}$/']; // Note: Keep [] on regex validation, there is a case here


        return $rules;
    }

    public function messages()
    {
        return [
            'name_ar.unique' => 'Customer name ar is used',
            'name_ar.required' => 'please enter Customer arabic name',
            'name_ar.max' => 'Customer max name ar letters are 255',

            'name_en.unique' => 'Customer name en is used',
            'name_en.required' => 'please enter Customer english name',
            'name_en.max' => 'Customer max name en letters are 255',

            'email.unique' => 'Customer email is used',
            'email.required' => 'please enter Customer email',
            'email.email' => 'Customer email must be valid of type email',

            'phone.unique' => 'Customer phone is used',
            'phone.required' => 'please enter Customer phone',
            'phone.numeric' => 'Customer phone must be valid of type numeric',
            'phone.regex' => 'Customer phone must be valid of the following:[0-9] range',

            
            'country_phone_id.required' => 'Country Phone is required !!',
            'country_phone_id.integer' => 'Country Phone must be an integer !!',
            'country_phone_id.numeric' => 'Country Phone must be must be a number !!',
            'not_valid_country_phone_id.required' => 'Country Phone ID is not valid !!', 

            'status.numeric' => 'Status must be a number',
            'status.integer' => 'Status must be an integer',
            'status.required' => 'Status is required',
            'not_valid_status.required' => 'Status value is not valid !!',

            'address.required' => 'Address is required',

            'image.mimes' => 'image must be of valid type :png,jpg,jpeg,gif,webp',

            'authorized_signatory.max' => 'Authorized signatory length must be maximum 250 letters',


        ];
    }
}
