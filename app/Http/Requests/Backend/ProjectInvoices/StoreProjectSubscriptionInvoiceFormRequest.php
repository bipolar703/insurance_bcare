<?php

namespace App\Http\Requests\Backend\ProjectInvoices;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectSubscriptionInvoiceFormRequest extends FormRequest
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
        // $dynamicMaxValue = isset($this->route('project')->total_contracts) ? (float) $this->route('project')->total_contracts : 0;

        // dd (($this));



        $validation_data =

            [
                'project_id' => 'required|numeric|integer',
                'id' => 'required|numeric|integer|unique:project_invoices,id',
                'customer_id' => 'required|numeric|integer',
                'subscription_id' => 'required|numeric|integer',
                'status' => 'required|numeric|integer',
                'amount' => [
                    'required',
                    'numeric',
                    'min:1',
                    function ($attribute, $value, $fail) {
                        $maxValue = isset($this->subscriptionTotal) ? (float) $this->subscriptionTotal : 0;

                        if ($value > $maxValue) {
                            $fail($attribute . ' cannot be greater than ' . $maxValue . '.');
                        }
                    },
                ],
                'payment_method' => 'required|numeric|integer',
                'note' => 'nullable'

            ];


        if ($this['payment_method'] == 2) {
            $validation_data['check_due_date'] = 'required|date';
        }
        if ($this['payment_method'] == 1) {
            $validation_data['check_due_date'] = 'nullable';
        }

        if ($this['status'] == 4) {
            $validation_data['receipt_file'] = 'required|mimes:png,jpg,webp,pdf';
            $validation_data['invoice_due_date'] = 'required|date';
        } else {
            $validation_data['receipt_file'] = 'nullable|mimes:png,jpg,webp,pdf';
        }

        return $validation_data;
    }

    public function messages()
    {
        return [
            // status
            'status.numeric' => 'Status must be a number',
            'status.integer' => 'Status must be an integer',
            'status.required' => 'Status is required',

            // project_id
            'project_id.numeric' => 'Project must be a number',
            'project_id.integer' => 'Project must be an integer',
            'project_id.required' => 'Project is required',

            // customer_id
            'customer_id.numeric' => 'Customer must be a number',
            'customer_id.integer' => 'Customer must be an integer',
            'customer_id.required' => 'Customer is required',

            'amount.required' => 'amount is required',
            'amount.numeric' => 'amount must be number',

            'receipt_file.mimes' => 'receipt file must be of valid type :png,jpg,webp,jpeg,pdf,doc,docx',
            'receipt_file.required' => 'receipt file is required'

        ];
    }
}
