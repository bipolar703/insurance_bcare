<?php

namespace App\Http\Requests\Backend\ProjectInvoices;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectInvoicesIDFormRequest extends FormRequest
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
            // 'id' => 'required|numeric|integer|unique:project_invoices,id',
            'id' => 'required|numeric|integer|unique:project_invoices,id,' . $this->id,

        ];
    }
}
