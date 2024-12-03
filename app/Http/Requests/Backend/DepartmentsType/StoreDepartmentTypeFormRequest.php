<?php

namespace App\Http\Requests\Backend\DepartmentsType;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentTypeFormRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title_ar' => 'required|unique:departments_types,title_ar',
            'title_en' => 'required|unique:departments_types,title_en',
            'status' => 'required|numeric|integer',
        ];
    }
}
