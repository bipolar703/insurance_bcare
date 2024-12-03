<?php

namespace App\Http\Requests\Backend\Leads;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadFormRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'authorized_signatory' => 'required',
            'status' => 'required|numeric|integer',
            'employee_id' => 'required|numeric|integer',
            'country_id' => 'nullable|numeric|integer',
            'city_id' => 'nullable|numeric|integer',
            'country_phone_id' => 'required|numeric|integer'
        ];
      // ============================= The Following Validation Done By Raghad ========================================

      if(isset($this->city_id)){
        $rules['country_id'] = 'required';
    }
    // Check the status value
    if (isset($this->status) && (($this->status != 1) && ($this->status != 2) && ($this->status != 3))) {
        $rules['not_valid_status'] = 'required';
    }
    // Check the country value
    if (isset($this->country_id) && (($this->country_id < 1) || $this->country_id > 250)) {
        $rules['not_valid_country'] = 'required';
    }
     // Check the country phone id value
     if (isset($this->country_phone_id) && (($this->country_phone_id < 1) || $this->country_phone_id > 250)) {
        $rules['not_valid_country_phone_id'] = 'required';
    }
     // Check the city value
     if (isset($this->city_id) && (($this->city_id < 1) || $this->city_id > 5038)) {
        $rules['not_valid_city'] = 'required';
    }
    // The phone and country_phone_id are unique
    $rules['phone'] = [ 'required', 'numeric', 'min:0',
    Rule::unique('leads')->ignore($this->id)->where(function ($query) {
        return $query->where('country_phone_id', request('country_phone_id'));
    }),
    'regex:/^[\d]{5,15}$/']; // Note: Keep [] on regex validation, there is a case here
    
        return $rules;
    }


    public function messages()
    {
        return [
            'title.required' => 'Title is required',

            'authorized_signatory.required' => 'Authorized Signatory is required',

            'address.required' => 'Address is required',

            'phone.required' => 'Phone is required',
            'phone.numeric' => 'Phone must Be Numeric',

            'email.required' => 'Email is required',
            'email.email' => 'Email must Be Valid',

            'status.required' => 'Status is required',
            'status.numeric' => 'Status must Be Numeric',
            'status.integer' => 'Status must Be Integer',

            'employee_id.required' => 'Employee is required',
            'employee_id.numeric' => 'Employee must Be Numeric',
            'employee_id.integer' => 'Employee must Be Integer',

            'country_id.required' => 'Country is required',
            'country_id.numeric' => 'Country must Be Numeric',
            'country_id.integer' => 'Country must Be Integer',

            'city_id.required' => 'City is required',
            'city_id.numeric' => 'City must Be Numeric',
            'city_id.integer' => 'City must Be Integer',

            'not_valid_status' => 'Status value is not valid',
            
            'not_valid_status' => 'Status value is not valid',
            'not_valid_country' => 'Country value is not valid',
            'not_valid_city' => 'City value is not valid',
            'not_valid_country_phone_id' => 'Country Phone Code value is not valid',

            'country_phone_id.required' => 'Country Phone is required',
            'country_phone_id.number' => 'Country Phone must be a number',
            'country_phone_id.required' => 'Country Phone must be an integer',

        ];
    }
}
