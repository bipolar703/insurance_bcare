<?php

namespace App\Http\Requests\Backend\Accounts;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountFormRequest extends FormRequest
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
        $usersArray = User::where('status', 1)->pluck('id')->toArray();
        $accountsArray = Account::where('status', 1)->where('id', '!=', $this->id)->pluck('id')->toArray();
        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'status' => 'required|numeric|integer|in:1,2',
            'account_type' => 'required|numeric|integer|in:1,2',
            'assigned_to_employee_id' => ['required', 'numeric', 'integer', Rule::in($usersArray)],
            'parent_id' => ['nullable', 'numeric', 'integer', Rule::in($accountsArray)],
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'title_ar.required' => 'Title AR is required',
            'title_en' => 'Title EN is required',

            'status.required' => 'Status is required',
            'status.numeric' => 'Status must be a number',
            'status.integer' => 'Status must be an integer',
            'status.in' => 'Status value is invalid',

            'account_type.required' => 'Account Type is required',
            'account_type.numeric' => 'Account Type must be a number',
            'account_type.integer' => 'Account Type must be an integer',
            'account_type.in' => 'Account Type value is invalid',

            'assigned_to_employee_id.required' => 'Assigned Employee is required',
            'assigned_to_employee_id.numeric' => 'Assigned Employee must be a number',
            'assigned_to_employee_id.integer' => 'Assigned Employee must be an integer',
            'assigned_to_employee_id.in' => 'Assigned Employee is invalid',

         
            'parent_id.numeric' => 'Account must be a number',
            'parent_id.integer' => 'Account must be an integer',
            'parent_id.in' => 'Account is invalid',

        ];
        
    }
}
