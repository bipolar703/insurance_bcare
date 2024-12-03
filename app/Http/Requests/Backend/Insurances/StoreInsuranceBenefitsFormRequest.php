<?php

namespace App\Http\Requests\Backend\Insurances;

use Illuminate\Foundation\Http\FormRequest;

class StoreInsuranceBenefitsFormRequest extends FormRequest
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
        $rules =  [
            'benefit_title' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'benefit_title.required' => 'Benefits Title is required !!',
        ];
    }
}
