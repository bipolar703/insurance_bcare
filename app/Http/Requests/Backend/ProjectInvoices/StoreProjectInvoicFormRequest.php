<?php

namespace App\Http\Requests\Backend\ProjectInvoices;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectInvoicFormRequest extends FormRequest
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
        $validation_data =

            [
                'project_id' => 'required|numeric|integer',
                'customer_id' => 'required|numeric|integer',
                'status' => 'required|numeric|integer',
                'amount' => 'required|numeric',
                'payment_method' => 'required|numeric|integer'


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
            $validation_data['invoice_due_date'] = 'nullable|date';
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
