<?php

namespace App\Http\Requests\Backend\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskAttchmentFormRequest extends FormRequest
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
            'file' => 'required|mimes:png,jpg,webp,pdf,doc,docx',
            'title' => 'required',
            'task_id' => 'required|numeric|integer',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'file.required' => 'file is required !!',
            'file.mimes' => 'file must be of supported type: mimes:pdf,word,xlsx',

            'task_id.required' => 'task is required !!',
            'task_id.numeric' => 'task must be of type numeric !!',
            'task_id.integer' => 'task must be of type integer !!',
        ];
    }
}
