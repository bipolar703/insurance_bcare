<?php

namespace App\Http\Requests\Backend\Payments;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentFormRequest extends FormRequest
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
        return [
            'payment_title' => 'required',
            'payment_date' => 'nullable|date',
            'payment_description' => 'nullable'
        ];
    }



    public function messages()
    {
        return [
            // payment_title
            'payment_title.required' => 'Payemnt Title is required',

            // payment_date
            'payment_date.date' => 'Payment Date Must Be Valid',
            'payment_date.required' => 'Payment Date is Required',
        ];
    }
}
