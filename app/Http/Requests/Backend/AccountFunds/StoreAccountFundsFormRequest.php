<?php

namespace App\Http\Requests\Backend\AccountFunds;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAccountFundsFormRequest extends FormRequest
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
    // ======================================= EDITED BY RAGHAD ======================================= 
    public function rules()
    {
        $fundArray = [1,2];
        $mainAccountsArray = Account::where('status', 1)->pluck('id')->toArray();
        $subAccountsArray = Account::where('parent_id', isset($this->from_account_id) ? $this->from_account_id : null)->pluck('id')->toArray();

        $rules = [
            'title' => 'required',
            'amount' => 'required|numeric',
            'fund_type' => ['required', 'numeric', 'integer', Rule::in($fundArray)],
            'from_account_id' => ['required', 'numeric', 'integer', Rule::in($mainAccountsArray)],
            'to_account_id' => ['nullable', 'numeric', 'integer', Rule::in($subAccountsArray)],
            'file' => 'nullable|mimes:png,jpg,pdf,jpeg',
        ];
        return $rules;
    }
    public function messages(){
        return [
            'title.required' => 'Title is required',

            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',

            'fund_type.required' => 'Fund Type is required',
            'fund_type.numeric' => 'Fund Type musy be a number',
            'fund_type.integer' => 'Fund Type must be an integer',
            'fund_type.in' => 'Fund Type is not valid',

            'from_account_id.required' => 'Main account is required',
            'from_account_id.numeric' => 'Main account musy be a number',
            'from_account_id.integer' => 'Main account must be an integer',
            'from_account_id.in' => 'Main account is not valid',

            'to_account_id.numeric' => 'Sub account musy be a number',
            'to_account_id.integer' => 'Sub account must be an integer',
            'to_account_id.in' => 'Sub account is not valid',

         
            'file.mimes' => 'File is not valid',
        ];
    }
}
