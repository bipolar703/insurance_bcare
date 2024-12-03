<?php

namespace App\Http\Requests\Backend\VarableAssets;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVariableAssetFormRequest extends FormRequest
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
    // ============================= EDITED BY: RAGHAD ============================= 
    public function rules()
    {
        $statusArray = [1 ,2]; // 1 => Active, 2 => Inactive
        $rules = [
            'title' => 'required',
            'quantity' => 'required|numeric|min:0',
            'status' => ['required','numeric','integer',Rule::in($statusArray)]
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'Title is required',

            'quantity.required' => 'Quantity is required',
            'quantity.numeric' => 'Quantity must be a number',
            'quantity.min' => 'Quantity must be at least 0',

            'status.required' => 'Status is required',
            'status.numeric' => 'Status must be a number',
            'status.integer' => 'Status must be an integer',
            'status.in' => 'Status is not valid',


        ];
    }
}
