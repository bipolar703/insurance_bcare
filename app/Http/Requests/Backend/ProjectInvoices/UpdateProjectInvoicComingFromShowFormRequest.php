<?php

namespace App\Http\Requests\Backend\ProjectInvoices;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectInvoicComingFromShowFormRequest extends FormRequest
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
    // public function rules()
    // {
    //     $validation_data =

    //         [
    //             'project_id' => 'required|numeric|integer',
    //             'customer_id' => 'required|numeric|integer',
    //             'status' => 'required|numeric|integer',
    //             'amount' => [
    //                 'required',
    //                 'numeric',
    //                 'min:1',
    //                 function ($attribute, $value, $fail) {
    //                     $maxValue = isset($this->totalMaxAmount) ? (float) $this->totalMaxAmount : 0;

    //                     if ($value > $maxValue) {
    //                         $fail($attribute . ' cannot be greater than ' . $maxValue . '.');
    //                     }
    //                 },
    //             ],
    //             'payment_method' => 'required|numeric|integer',
    //             'note' => 'nullable'
    //             // 'receipt_file' => [
    //             //     function ($attribute, $value, $fail) {
    //             //         if (isset($this->project->receipt_file)) {
    //             //             $this->merge(['receipt_file' => $value]);
    //             //         } else {
    //             //             $fail('The ' . $attribute . ' is required.');
    //             //         }
    //             //     },
    //             //     'file',
    //             //     'mimes:png,jpg,webp,jpeg,pdf,doc,docx',
    //             // ],

    //         ];


    //     if ($this['payment_method'] == 2) {
    //         $validation_data['check_due_date'] = 'required|date';
    //     }
    //     if ($this['payment_method'] == 1) {
    //         $validation_data['check_due_date'] = 'nullable';
    //     }

    //     if ($this['status'] == 4) {
    //         $validation_data['receipt_file'] = 'required|mimes:png,jpg,webp,pdf';
    //         $validation_data['invoice_due_date'] = 'required|date';
    //     } else {
    //         $validation_data['receipt_file'] = 'nullable|mimes:png,jpg,webp,pdf';
    //     }

    //     return $validation_data;
    // }

    public function rules()
    {
        $validationData = [
            'project_id' => 'required|numeric|integer',
            'customer_id' => 'required|numeric|integer',
            // 'id' => 'required|numeric|integer|unique:project_invoices,id,' . $this->id,

            'status' => 'required|numeric|integer',
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
            'payment_method' => 'required|numeric|integer',
            'note' => 'nullable'
        ];

        if ($this['payment_method'] == 2) {
            $validationData['check_due_date'] = 'required|date';
        }
        if ($this['payment_method'] == 1) {
            $validationData['check_due_date'] = 'nullable';
        }

        if ($this['status'] == 4) {
            $validationData['receipt_file'] = 'required|mimes:png,jpg,webp,pdf';
            $validationData['invoice_due_date'] = 'required|date';
        } else {
            $validationData['receipt_file'] = 'nullable|mimes:png,jpg,webp,pdf';
        }

        return $validationData;
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
