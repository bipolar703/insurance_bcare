<?php

namespace App\Http\Requests\Backend\Insurances;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInsuranceFormRequest extends FormRequest
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
        $insuranceTypeArray = [1, 2]; // الأول (1) => ضد الغير || الثاني (2) => شامل
        $statusArray = [1, 2]; // 1 => Active || 2 => Inactive

        $rules =  [
            'insurance_type' => ['required', 'integer', Rule::in($insuranceTypeArray)],
            'image' => 'mimes:jpeg,jpg,png,gif,tiff,tif,webp',
            'price' => 'required|numeric',
            'status' => ['required', 'integer', Rule::in($statusArray)],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'insurance_type.required' => 'Insurance Type is required !!',
            'insurance_type.integer' => 'Insurance Type must be an integer !!',
            'insurance_type.in' => 'Insurance Type ID is not valid !!',
            
            'image.mimes' => 'Image type must be jpeg,jpg,png,gif,tiff,tif or webp !!',
            
            'price.required' => 'Price is required !!',
            'price.numeric' => 'Price must be a number !!',

            'status.integer' => 'Status must be an integer !!',
            'status.required' => 'Status is required !!',
            'status.in' => 'Status value is not valid !!',
        ];
    }
}
