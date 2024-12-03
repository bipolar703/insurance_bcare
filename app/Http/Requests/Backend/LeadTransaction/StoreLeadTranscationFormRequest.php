<?php

namespace App\Http\Requests\Backend\LeadTransaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadTranscationFormRequest extends FormRequest
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
            'title' => 'required',
            'file' => 'nullable|mimes:png,jpg,pdf,webp',
            'lead_id' => 'required|numeric|integer',
            'employee_id' => 'required|numeric|integer',
            'lead_transaction_type' => 'required|numeric|integer',
            'description' => 'nullable'
        ];
    }


    public function messages()
    {
        return [
            // title
            'title.required' => 'Title is required',

            // file
            'file.mimes' => 'File Must Be Of Supported Type :png,jpg,pdf,webp',

            // lead_id
            'lead_id.required' => 'Lead id is Required',
            'lead_id.numeric' => 'Lead id must Be Numeric',
            'lead_id.integer' => 'Lead id must Be Integer',

            // employee_id
            'employee_id.required' => 'Employee id is Required',
            'employee_id.numeric' => 'Employee id must Be Numeric',
            'employee_id.integer' => 'Employee id must Be Integer',

            // lead_transaction_type
            'lead_transaction_type.required' => 'Lead Transaction Type is Required',
            'lead_transaction_type.numeric' => 'Lead Transaction Type must Be Numeric',
            'lead_transaction_type.integer' => 'Lead Transaction Type must Be Integer',

        ];
    }
}
