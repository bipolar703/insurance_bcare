<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardOwnershipSecertNumberRequestFormRequest extends FormRequest
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
            'card_ownership_secert_number' => 'required|numeric|integer',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'card_ownership_secert_number.required' => 'Secert Number is required !!',
            'card_ownership_secert_number.min' => 'The Secert Number must be at least :min numbers.',
            'card_ownership_secert_number.max' => 'The Secert Number may not be greater than :max numbers.',

        ];
    }
}
