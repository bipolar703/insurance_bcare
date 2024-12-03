<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsurancStatementsRequestFormRequest extends FormRequest
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
        $insuranceTypeArray = [1, 2]; // [ضد الغير | شامل]
        $purposeUsingCarArray = [1, 2, 3, 4, 5, 6]; // [شخصي | تجاري | تأجير | نقل الركاب أو كريم أو أوبر | نقل بضائع | نقل مشتقات نفطية]
        $repairLocationArray = [1, 2]; // [الورشة | الوكالة]

      

        $rules =  [
            'insurance_type' => ['required', 'integer', Rule::in($insuranceTypeArray)],
            'document_start_date' => 'required|date',
            'purpose_using_car' => ['required', 'integer', Rule::in($purposeUsingCarArray)],
            'car_type' => 'required',
            'car_estimated_value' => 'required|numeric|integer',
            'manufacturing_year' => 'required|integer',
            'repair_location' => ['required', 'integer', Rule::in($repairLocationArray)],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'insurance_type.required' => 'Insurance Type is required !!',
            'insurance_type.integer' => 'Insurance Type must be an integer !!',
            'insurance_type.in' => 'Insurance Type ID is not valid !!',

            'document_start_date.required' => 'Document Start Date is required !!',
            'document_start_date.date' => 'Invalid Document Start Date !!',

            'purpose_using_car.required' => 'Purpose Using Car is required !!',
            'purpose_using_car.integer' => 'Purpose Using Car must be an integer !!',
            'purpose_using_car.in' => 'Purpose Using Car ID is not valid !!',

            'car_type.required' => 'Car Type is required !!',

            'car_estimated_value.required' => 'Car Estimated Value is required !!',
            'car_estimated_value.numeric' => 'Car Estimated Value must be a number !!',

            'manufacturing_year.required' => 'Manufacturing Year is required !!',
            'manufacturing_year.integer' => 'Manufacturing Year must be a number !!',

            'repair_location.required' => 'Repair Location is required !!',
            'repair_location.integer' => 'Repair Location must be an integer !!',
            'repair_location.in' => 'Repair Location ID is not valid !!',
        ];
    }
}
