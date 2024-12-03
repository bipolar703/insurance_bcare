<?php

namespace App\Http\Requests\Backend\ProjectInvoices;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreProjectInvoicComingFromShowFormRequest extends FormRequest
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

    // ===================================== EDITED BY: RAGHAD =====================================

    public function rules()
    {
        $statusArray = [1,4]; // 1 => Open, 4 => Paid
        $paymentsMethodsArray = [1,2]; // 1 => Cash, 2 => Check
        $validationData = [
            'id' => 'required|numeric|integer|unique:project_invoices,id',
            'status' => ['required','numeric','integer', Rule::in($statusArray)],
            'amount' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    $maxValue = isset($this->totalMaxAmount) ? (float) $this->totalMaxAmount : 0;

                    if ($value > $maxValue) {
                        $fail($attribute . ' cannot be greater than ' . $maxValue . '.');
                    }
                },
                function ($attribute, $value, $fail) {
                    if (is_null($this->fee_amount)) {
                        // If fee amount data is missing, no validation needed
                        return;
                    }

                    if (!is_array($this->fee_amount)) {
                        // Handle the case where $this->fee_amount is not an array
                        $fail('The fee amount data is invalid.');
                        return;
                    }

                    $totalFees = array_sum($this->fee_amount);

                    if ($value <= $totalFees) {
                        $fail('The total amount must be greater than the total fees.');
                    }
                }

            ],
            'payment_method' => ['required','numeric','integer', Rule::in($paymentsMethodsArray)],
        ];
        // If Payment method is Check
        if ($this['payment_method'] == 2) {
            $validationData['check_due_date'] = 'required|date|date_format:Y-m-d';
        }else{
            $validationData['check_due_date'] = 'nullable|date|date_format:Y-m-d';
        }
        // If status is paid
        if ($this['status'] == 4) {
            $validationData['receipt_file'] = 'required|mimes:png,jpg,webp,pdf';
            $validationData['invoice_due_date'] = 'required|date|date_format:Y-m-d';
        } else {
            $validationData['receipt_file'] = 'nullable|mimes:png,jpg,webp,pdf';
            $validationData['invoice_due_date'] = 'nullable|date|date_format:Y-m-d';
        }
        return $validationData;
    }



    public function messages()
    {
        return [
            // Status
            'status.numeric' => 'Status must be a number',
            'status.integer' => 'Status must be an integer',
            'status.required' => 'Status is required',
            'status.in' => 'Status is not valid',
            // Payment Method
            'payment_method.numeric' => 'Payment method must be a number',
            'payment_method.integer' => 'Payment method must be an integer',
            'payment_method.required' => 'Payment method is required',
            'payment_method.in' => 'Payment method is not valid',
            // Amount
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be number',
            'amount.min' => 'Amount must be at least 1',
            // Recipt File
            'receipt_file.mimes' => 'Receipt file must be of valid type :png,jpg,webp,jpeg,pdf,doc,docx',
            'receipt_file.required' => 'Receipt file is required',
            // Check Due Date
            'check_due_date.required' => 'Check Due Date is required',
            'check_due_date.date' => 'Check Due Date is not valid',
            'check_due_date.date_format' => 'Check Due Date is not valid',
            // Invoice Due Date
            'invoice_due_date.required' => 'Invoice Due Date is required',
            'invoice_due_date.date' => 'Invoice Due Date is not valid',
            'invoice_due_date.date_format' => 'Invoice Due Date is not valid',
        ];
    }
}
