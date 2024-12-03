<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class NafathLoginRequestFormRequest extends FormRequest
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
        $rules =  [
            'identity_number' => 'required|min:10|max:10',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'identity_number.required' => 'Identity Number/Residence Card Number is required !!',
            'identity_number.integer' => 'Identity Number/Residence Card Number must be a number !!',
            'identity_number.min' => 'Identity Number/Residence Card Number must be at least :min numbers.',
            'identity_number.max' => 'Identity Number/Residence Card Number may not be greater than :max numbers.',
        ];
    }
}
