<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsurancRequesteFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $insuranceCategoryArray = [1]; // جديد
        $newInsuranceCategoryArray = [1]; // الرقم التسلسلي

        $rules =  [
            'insurance_category' => ['required', 'integer', Rule::in($insuranceCategoryArray)],
            'new_insurance_category' => ['required', 'integer', Rule::in($newInsuranceCategoryArray)],
            'identity_number' => 'required|integer|numeric',
            'applicant_name' => 'required',
            'phone' => 'required',
            'date_of_birth' => 'required|date',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'insurance_category.required' => 'Insurance Category is required !!',
            'insurance_category.integer' => 'Insurance Category must be an integer !!',
            'insurance_category.in' => 'Insurance Category ID is not valid !!',
            
            'new_insurance_category.required' => 'New Insurance Category is required !!',
            'new_insurance_category.integer' => 'New Insurance Category must be an integer !!',
            'new_insurance_category.in' => 'New Insurance Category ID is not valid !!',
            
            'identity_number.required' => 'Identity Number is required !!',
            'identity_number.integer' => 'Identity Number must be a number !!',
            'identity_number.min' => 'Identity Number must be at least :min numbers.',
            'identity_number.max' => 'Identity Number may not be greater than :max numbers.',

            
            'applicant_name.required' => 'Applicant Name is required !!',
            
            'phone.required' => 'Phone is required !!',
            'phone.min' => 'Identity Number must be at least :min numbers.',
            'phone.max' => 'Identity Number may not be greater than :max numbers.',

            'date_of_birth.required' => 'Date of Birth is required !!',
            'date_of_birth.date' => 'Invalid Date of Birth !!',
        ];
    }
}
