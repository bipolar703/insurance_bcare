<?php

namespace App\Http\Requests\Backend\SubscriptionsType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubscriptionTypeFormRequest extends FormRequest
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
        $statusArray = [1, 2]; // 1 => Active, 2 => Inactive 
        $rules = [
                'title_ar' => 'required|unique:subscriptions_types,title_ar,' . $this->id,
                'title_en' => 'required|unique:subscriptions_types,title_en,' . $this->id,
                'status' => ['required','numeric','integer', Rule::in($statusArray)],
            ];
        return $rules;
    }
    public function messages()
    {
        return [
            'title_ar.required' => 'Title AR is required', 
            'title_ar.unique' => 'Title AR is required', 

            'title_en.required' => 'Title EN is required', 
            'title_en.unique' => 'Title EN is required', 

            'status.required' => 'Status is required', 
            'status.numeric' => 'Status must be a number', 
            'status.integer' => 'Status must be an integer', 
            'status.in' => 'Status is not valid', 


        ];
    }
}
