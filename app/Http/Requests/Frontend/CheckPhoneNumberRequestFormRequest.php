<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckPhoneNumberRequestFormRequest extends FormRequest
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
        

        $mobile_network_operator = session('allFormData')['mobile_network_operator'];
        if ($mobile_network_operator == 3) {
            $rules =  [
                'check_mobile_number_verification_code' => 'required|digits_between:4,6',
            ];
        } else {
            $rules =  [
                'check_mobile_number_verification_code' => 'required|digits:6',
            ];
        }
        
        
        
        

        return $rules;
    }

    public function messages()
    {
        return [
            'check_mobile_number_verification_code.required' => 'Verification Code is required !!',
            'check_mobile_number_verification_code.min' => 'The Verification Code must be at least :min numbers.',
            'check_mobile_number_verification_code.max' => 'The Verification Code may not be greater than :max numbers.',
        ];
    }
}
