<?php

namespace App\Http\Requests\Backend\Expenses;

use App\Models\Account;
use App\Models\ExpenseCategory;
use App\Models\ExpenseLocation;
use App\Models\VariableAsset;
use App\Models\Vendor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpensesFormRequest extends FormRequest
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
    // ========================================= EDITED BY: RAGHAD =========================================     
    public function rules()
    {
        $expensesTypesArray = ExpenseCategory::where('status', 1)->pluck('id')->toArray();
        $expenseLocationsArray = ExpenseLocation::where('status', 1)->pluck('id')->toArray();
        $variableAssetsArray = VariableAsset::where('status', '=', '1')->pluck('id')->toArray();
        $vendorsArray = Vendor::where('status', '=', '1')->pluck('id')->toArray();
        $accountsArray = Account::where('status', '=', '1')->pluck('id')->toArray();

        $rules = [
            'title' => 'required',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date|date_format:Y-m-d',
            'category_id' => ['required','numeric','integer',Rule::in($expensesTypesArray)],
            'location_id' => ['required','numeric','integer',Rule::in($expenseLocationsArray)],
            'account_id' => ['required','numeric','integer',Rule::in($accountsArray)],
            'vendor_id' => ['nullable','numeric','integer',Rule::in($vendorsArray)],
            'asset_id' => ['nullable','numeric','integer',Rule::in($variableAssetsArray)],
            'expense_file' => 'required|mimes:png,jpg,jpeg,webp,pdf',
        ];
        return $rules;
    }
    public function messages(){
        return [
            'title.required' => 'Title is required',
            // Amount
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'amount.min' => 'Amount must be at least 0.01',
            // Expense Date
            'expense_date.required' => 'Expense Date is required',
            'expense_date.date' => 'Expense Date is not valid',
            'expense_date.date_format' => 'Expense Date is not valid',
            // Category ID
            'category_id.required' =>'Category is required',
            'category_id.numeric' => 'Category must be a number',
            'category_id.integer' => 'Category must be an integer',
            'category_id.in' => 'Category is not valid',
            // Location ID
            'location_id.required' =>'Location is required',
            'location_id.numeric' => 'Location must be a number',
            'location_id.integer' => 'Location must be an integer',
            'location_id.in' => 'Location is not valid',
            // Account
            'account_id.required' =>'Account is required',
            'account_id.numeric' => 'Account must be a number',
            'account_id.integer' => 'Account must be an integer',
            'account_id.in' => 'Account is not valid',
            // Vendor
            'vendor_id.numeric' => 'Vendor must be a number',
            'vendor_id.integer' => 'Vendor must be an integer',
            'vendor_id.in' => 'Vendor is not valid',
            // Assest ID
            'asset_id.numeric' => 'Variable Asset must be a number',
            'asset_id.integer' => 'Variable Asset must be an integer',
            'asset_id.in' => 'Variable Asset is not valid',
            // Expense File
            'expense_file.required' => 'Expense File is required',
            'expense_file.mimes' => 'Expense File is not valid',

        ];
    }
}
