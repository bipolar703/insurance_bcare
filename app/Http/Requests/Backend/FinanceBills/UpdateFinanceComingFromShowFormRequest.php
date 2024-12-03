<?php

namespace App\Http\Requests\Backend\FinanceBills;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFinanceComingFromShowFormRequest extends FormRequest
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
        return [
            'project_id' => 'required|numeric|integer',
            'customer_id' => 'required|numeric|integer',
            'status' => 'required|numeric|integer',
            'amount' => 'required|numeric',
            'receipt_file' => 'mimes:png,jpg,webp,jpeg,pdf,doc,docx'

        ];
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
            'receipt_file.required' => 'receipt_file is required'

        ];
    }
}
