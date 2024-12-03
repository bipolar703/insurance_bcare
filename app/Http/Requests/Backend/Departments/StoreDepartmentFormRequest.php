<?php

namespace App\Http\Requests\Backend\Departments;

use App\Models\DepartmentsType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentFormRequest extends FormRequest
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
    
    // ======================================== Edited By Raghad ========================================
   
    public function rules()
    {
        $statusArray = [1, 2]; // 1 => Active, 2 => Inactive
        $typeArray = DepartmentsType::status(1)->pluck('id');
        $rules = [
            'name' => 'required',
            'code' => 'required|unique:departments,code,',
            'status' => ['required', 'numeric', 'integer', Rule::in($statusArray)],
            'department_type_id' => ['required', 'numeric', 'integer', Rule::in($typeArray)],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required !!',

            'code.required' => 'Code is required !!',
            'code.unique' => 'Department code must be unique',

            'status.required' => 'Status is required !!',
            'status.numeric' => 'Status must be of type numeric !!',
            'status.integer' => 'Status must be of type integer !!',
            'status.in' => 'Status value is not valid !!',

            'department_type_id.required' => 'Type is required !!',
            'department_type_id.numeric' => 'Type must be of type numeric !!',
            'department_type_id.integer' => 'Type must be of type integer !!',
            'department_type_id.in' => 'Type value is not valid !!',

        ];
    }
}
