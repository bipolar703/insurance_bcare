<?php

namespace App\Http\Requests\Backend\Projects;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectAttachmentsFormRequest extends FormRequest
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
        //  ======================== EDITED BY RAGHAD ======================== 
        return [
            'project_attachments_title' => 'required',
            'project_attachments_files' => 'required',
            'project_attachments_files.*' => 'mimes:png,jpg,webp,pdf',
        ];
        
    }

    public function messages()
    {
        return [
            'project_attachments_files.required' => 'Files are required !!',
            'project_attachments_files.*.mimes' => 'Files must be of supported type: mimes:png,jpg,webp,pdf,doc,docx',
            'project_attachments_title.required' => 'Files title is required',

        ];
    }
}
