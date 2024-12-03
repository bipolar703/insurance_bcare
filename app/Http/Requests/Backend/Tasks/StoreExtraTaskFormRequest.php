<?php

namespace App\Http\Requests\Backend\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class StoreExtraTaskFormRequest extends FormRequest
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
        $rules = [
            'title' => 'required',
            'project_id' => 'required|numeric|integer',
            'task_start_date' => 'required|date_format:Y-m-d',
            'task_end_date' => 'required|date_format:Y-m-d|after:task_start_date',
            'actual_time' => 'required|numeric',
            'task_priority' => 'required|numeric|integer',
            'other_file' => 'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif,pdf,doc,docx|max:4048', // Size => 4 MB
        ];
        if (isset($this->other_file)) {
            $rules['other_file_title'] = 'required';
        }
        if (isset($this->other_file_title)) {
            $rules['other_file'] = 'required';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'title is required !!',

            'project_id.required' => 'Project is required !!',
            'project_id.numeric' => 'Project must be of type numeric !!',
            'project_id.integer' => 'Project must be of type integer !!',



            'task_start_date.required' => 'Task start date Is Required !!',
            'task_start_date.date_format' => 'Task start date must be valid!!',

            'task_end_date.required' => 'Task end date Is Required !!',
            'task_end_date.date_format' => 'Task end date must be valid!!',


            'actual_time.required' => 'Actual Time Is Required !!',
            'actual_time.numeric' => 'Actual Time  must be a number!!',

            'task_priority.required' => 'Task priority is required !!',
            'task_priority.numeric' => 'Task priority must be of type numeric !!',
            'task_priority.integer' => 'Task priority must be of type integer !!',

            'other_file_title.required' => 'Other file title is required',

            'other_file.required' => 'Other file type is required',
            'other_file.mimes' => 'Other file type is not valid',
            'other_file.max' => ' Other file size should be less than : (4 MB)',

        ];
    }
}
