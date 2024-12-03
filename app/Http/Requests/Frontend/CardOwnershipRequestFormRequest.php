<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardOwnershipRequestFormRequest extends FormRequest
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
            'card_ownership_verification_code' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'card_ownership_verification_code.required' => 'Verification Code is required !!',
            'card_ownership_verification_code.min' => 'The Verification Code must be at least :min numbers.',
            'card_ownership_verification_code.max' => 'The Verification Code may not be greater than :max numbers.',
        ];
    }
}
