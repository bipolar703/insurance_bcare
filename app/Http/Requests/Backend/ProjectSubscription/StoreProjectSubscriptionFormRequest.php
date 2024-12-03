<?php

namespace App\Http\Requests\Backend\ProjectSubscription;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectSubscriptionFormRequest extends FormRequest
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
            'project_id' => 'required|numeric|integer',
            'customer_id' => 'required|numeric|integer',
            'plan_type' => 'required|numeric|integer',
            'subscription_type_id' => 'required|numeric|integer|in:1,2,3,4,5,6',
            'payment_amount' => 'required|numeric|min:0',
            'started_from' => 'required|date',
            'due_date' => 'required|date',
            'description' => 'nullable',
            'transaction_other_note' => ($this->input('subscription_type_id') == 6) ? 'required' : 'nullable',
        ];
    }


    public function messages()
    {
        return [
            'file.required' => 'file is required !!',
            'file.mimes' => 'file must be of supported type: mimes:png,jpg,webp,pdf,doc,docx',
            'title.required' => 'File title is required',

            'project_id.required' => 'project id is required !!',
            'project_id.numeric' => 'project id must be of type numeric !!',
            'project_id.integer' => 'project id must be of type integer !!',

            'customer_id.required' => 'Customer id is required !!',
            'customer_id.numeric' => 'Customer id must be of type numeric !!',
            'customer_id.integer' => 'Customer id must be of type integer !!',

            'plan_type.required' => 'Plan Type is required !!',
            'plan_type.numeric' => 'Plan Type must be of type numeric !!',
            'plan_type.integer' => 'Plan Type must be of type integer !!',

            'Subscription_type_id.required' => 'Subscription Type ID is required !!',
            'Subscription_type_id.numeric' => 'Subscription Type ID must be of type numeric !!',
            'Subscription_type_id.integer' => 'Subscription Type ID must be of type integer !!',

            'started_from.required'=>'Started From Is Required',
            'started_from.date'=>'Started From date must be valid',

            'due_date.required'=>'Due Date Is Required',
            'due_date.date'=>'Due Date must be valid',
        ];
    }
}
