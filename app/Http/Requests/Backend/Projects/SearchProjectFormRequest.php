<?php

namespace App\Http\Requests\Backend\Projects;

use Illuminate\Foundation\Http\FormRequest;

class SearchProjectFormRequest extends FormRequest
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
            'name' => 'nullable',
            'customerID' => 'nullable|numeric',
            'projectID' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email'
        ];
    }

    public function messages()
    {
        return [
            'customerID.required' => 'Customer id is required !!',
            'customerID.numeric' => 'Customer id must be of type numeric !!',
            'customerID.integer' => 'Customer id must be of type integer !!',

            'projectID.required' => 'Project id is required !!',
            'projectID.numeric' => 'Project id must be of type numeric !!',
            'projectID.integer' => 'Project id must be of type integer !!',

            'status.required' => 'Status id is required !!',
            'status.numeric' => 'Status id must be of type numeric !!',
            'status.integer' => 'Status id must be of type integer !!',
        ];
    }
}
