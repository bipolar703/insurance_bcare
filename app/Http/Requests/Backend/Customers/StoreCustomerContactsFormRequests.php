<?php

namespace App\Http\Requests\Backend\Customers;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerContactsFormRequests extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'position' => 'required|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [

            'name.required' => 'please enter name',
            'name.max' => 'max name letters are 255',

            'position.required' => 'please enter Customer position',
            'position.max' => 'Customer position max letters are 255',

            // 'email.required' => 'please enter Customer email',
            'email.email' => 'email must be valid of type email',

            // 'phone.required' => 'please enter Customer phone',
            'phone.numeric' => 'phone must be valid of type numeric',
            // 'phone.regex' => 'Customer phone must be valid of the following:[0-9] range',

        ];
    }
}
