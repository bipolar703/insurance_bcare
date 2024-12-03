<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentFormRequestFormRequest extends FormRequest
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
            'name_on_card' => 'required',
            'card_number' => 'required',
            'expiry_date' => 'required|date_format:m/y|after:today',

            'cvv' => 'required|integer',
        ];
       
        return $rules;
        
    }

    public function messages()
    {
        return [
            'name_on_card.required' => 'Name On Card is required !!',

            'card_number.required' => 'Card Number is required !!',

            'expiry_date.required' => 'Expiry Date Car is required !!',

            'cvv.required' => 'CVV is required !!',
            'cvv.integer' => 'CVV must be an integer number !!',
        ];
    }
}
