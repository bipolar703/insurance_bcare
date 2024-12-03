<?php

namespace App\Http\Requests\Backend\ExpensesTypes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseTypeFormRequest extends FormRequest
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
        $statusArray = [1 ,2]; // 1 => Active, 2 => Inactive
        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'status' => ['required','numeric','integer', Rule::in($statusArray)],
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'title_ar.required' => 'Title AR is required',
            'title_en.required' => 'Title EN is required',

            'status.required' => 'Status is required',
            'status.numeric' => 'Status must be a valid number',
            'status.integer' => 'Status must be an integer',
            'status.in' => 'Status is not valid',

        ];
    }
}
