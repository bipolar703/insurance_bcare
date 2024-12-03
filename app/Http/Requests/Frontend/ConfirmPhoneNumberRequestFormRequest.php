<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConfirmPhoneNumberRequestFormRequest extends FormRequest
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
        // dd($this->request);
        $mobileNetworkOperatorArray = [1, 2, 3, 4, 5];

        $rules =  [
            'mobile_network_operator' => ['required', 'integer', Rule::in($mobileNetworkOperatorArray)],
            'mobile_number' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'mobile_network_operator.required' => 'Mobile Network is required !!',
            'mobile_network_operator.integer' => 'Mobile Network must be an integer !!',
            'mobile_network_operator.in' => 'Mobile Network ID is not valid !!',

            'mobile_number.required' => 'Mobile Number is required !!',
            'mobile_number.min' => 'Mobile Number must be at least :min numbers.',
        ];
    }
}
