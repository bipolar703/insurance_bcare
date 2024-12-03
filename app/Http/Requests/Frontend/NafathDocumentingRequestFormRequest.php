<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class NafathDocumentingRequestFormRequest extends FormRequest
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
            'user_name' => 'required',
            'password' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'identity_number.required' => 'Identity Number/Residence Card Number is required !!',
            'password.required' => 'Username / National ID is required !!',
           
        ];
    }
}