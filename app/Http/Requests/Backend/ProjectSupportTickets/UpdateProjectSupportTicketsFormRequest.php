<?php

namespace App\Http\Requests\Backend\ProjectSupportTickets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectSupportTicketsFormRequest extends FormRequest
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
    // ============================================ Edited By Raghad ============================================ 

    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date|date_format:Y-m-d',
        ];
    }
    public function messages(){
        return [

            'title.required' => 'Title is required !!',
            'description.required' => 'Description is required !!',
            'date.required' => 'Date is required !!',
            'date.date' => 'Date is not valid !!',
            'date.date_format' => 'Date is not valid!!',

        ];
    }
}
