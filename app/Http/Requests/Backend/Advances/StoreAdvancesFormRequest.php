<?php

namespace App\Http\Requests\Backend\Advances;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvancesFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
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
        $rules = [
            'employee_id' => 'required|numeric|integer',
            'account_id' => 'required|numeric|integer',
            'title' => 'required',
            'payment_on_salary' => 'required|numeric|integer|in:1,2',
            'amount' => 'required|numeric|min:1',
            'monthly_payment' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($value > $this->input('amount')) {
                        $fail('The ' . $attribute . ' must be less than or equal to the amount.');
                    }
                },
            ],
            'file' => 'nullable|mimes:png,jpg,jpeg,pdf',
        ];

        if ($this->payment_on_salary == 1) {
            $rules['monthly_payment'][] = 'required';
        }

        return $rules;
    }
}
