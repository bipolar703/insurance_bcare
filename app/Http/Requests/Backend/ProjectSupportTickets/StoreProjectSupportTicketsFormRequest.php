<?php

namespace App\Http\Requests\Backend\ProjectSupportTickets;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectSupportTicketsFormRequest extends FormRequest
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
            'support_ticket_title' => 'required',
            'support_ticket_description' => 'required',
            'support_ticket_date' => 'required|date|date_format:Y-m-d',
        ];
    }
    public function messages(){
        return [

            'support_ticket_title.required' => 'Title is required !!',
            'support_ticket_description.required' => 'Description is required !!',
            'support_ticket_date.required' => 'Date is required !!',
            'support_ticket_date.date' => 'Date is not valid !!',
            'support_ticket_date.date_format' => 'Date is not valid!!',

        ];
    }
    
   
}
