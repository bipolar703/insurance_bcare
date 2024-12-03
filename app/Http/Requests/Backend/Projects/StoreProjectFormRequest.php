<?php

namespace App\Http\Requests\Backend\Projects;

use App\Models\Customer;
use App\Models\SubscriptionsType;
use App\Models\User;
use App\Rules\CustomCheckboxValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreProjectFormRequest extends FormRequest
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

    //  ============================================================================================
    //  ======================================== Edited By Raghad ==================================
    //  ============================================================================================

    public function rules()
    {
    
       
        $customersArray = Customer::where('status', '=', 1)->pluck('id')->toArray();
        $salesmenArray = User::where('status', 1)
        ->whereHas('department', function ($query) {
            $query->where('department_type_id', 4);
        })
        ->with('department')
        ->pluck('id')->toArray();
      
        $typeArray = [1, 2, 3, 4, 5, 6, 7, 8, 9]; // 1 => Web || 2 => Mobile || 3 => Web + Mobile || 4 => Hosting || 5=> Support || 6=> Design || 7=> Social Media || 8=> Design + Social Media || 9=> Other
        $countriesArray = range(1, 250); // Each number represent a contry and its data
        $subscriptionsStatusArray = [1 ,2]; // 1 => No, 2 => Yes
        $subscriptionsTypesArray = SubscriptionsType::where('status', 1)->pluck('id')->toArray();
        $rules = [
            'name_en' => 'required',
            'name_ar' => 'required',
            'type' => ['required', 'numeric', 'integer', Rule::in($typeArray)],
            'customer_id' => ['required', 'numeric' , 'integer', Rule::in($customersArray)],
            'project_salesman' => ['required', 'numeric' , 'integer', Rule::in($salesmenArray)],
            'subscriptions_status' => ['required', 'numeric', 'integer', Rule::in($subscriptionsStatusArray)],
            'total_contracts' => 'required|numeric|min:1',
            'signing_date' => 'required|date|date_format:Y-m-d',


            'total_hosting' => 'nullable|numeric|min:0',
            'total_support' => 'nullable|numeric|min:0',
            'due_date_hosting' => 'nullable|date|date_format:Y-m-d',
            'launch_date' => 'nullable|date|date_format:Y-m-d',
            'description' => 'nullable',


            'customer_project_coordinator_name' => 'nullable',
            'customer_project_coordinator_phone' => 'nullable|numeric',
            'country_phone_id' => ['nullable', 'numeric','integer', Rule::in($countriesArray)],
            
            'payment_title' => 'required|array',
            'payment_title.*' => 'required|string',

            'payment_amount' => 'required|array',
            'payment_amount.*' => 'required|numeric|min:1',

            'payment_date' => 'nullable|array',
            'payment_date.*' => 'nullable|date',

            'payment_description' => 'nullable|array',
            'payment_description.*' => 'nullable|string',

            'file' => 'nullable|mimes:png,jpg,webp,pdf',
            'title' => 'nullable',

            'domain_url' =>'nullable|url',
            'due_date_support' =>'nullable|date|date_format:Y-m-d',

            'payment_amount.*' => [
                'numeric',
                'min:1',
                Rule::requiredIf(function () {
                    // Check if payment_amount is not empty
                    return !empty($this->input('payment_amount'));
                }),
               
            ],
            'payment_date.*' => [
                'nullable',
                'date',
                'date_format:Y-m-d', // Valid date format if payment_date is filled
            ],
        ];
     
       // ========== PHONE & COUNTRY CODE ==========
        if (isset($this->customer_project_coordinator_phone)) {
           $rules['country_phone_id'] = ['required', 'numeric','integer', Rule::in($countriesArray)];
           $phoneValue = $this->input('customer_project_coordinator_phone');
           $phoneLength = strlen(preg_replace('/\D/', '', $phoneValue )); // Remove non-numeric characters
            if ($phoneLength < 9 || $phoneLength > 15) {
                $rules['phone_not_valid'] = 'required';
            }
        }
        if (isset($this->country_phone_id)) {
            $rules['country_phone_id'] = ['numeric','integer', Rule::in($countriesArray)];
            $rules['customer_project_coordinator_phone'] = 'required';
            
         }
        //  ========== Check contract file and title ==========
        if(isset($this->file)){
            $rules['title'] = 'required';
        }
        if (isset($this->title)) {
            $rules['file'] = 'required';
        }
        // ========== Total payment in table ==========
        $totalContracts = $this->input('total_contracts');
        $totalPayments = array_sum($this->input('payment_amount', []));
        if ($totalContracts != $totalPayments) {
            $rules['total_payment_table'] = 'required';
        }

        // ========== Subscriptions status and types  ==========
        if (isset($this->subscriptions_status) &&  ($this->subscriptions_status == 2)) {
            $amountsArray = [];
            // Add all amount inputs that start with subscription_type_amount to amountsArray array, after checking they are not empty and there valure are numeric
            foreach ($this->all() as $inputName => $inputValue) {
                if (strpos($inputName, 'subscription_type_amount') === 0 && !empty($inputValue) && is_numeric($inputValue)) {
                    $amountsArray[] = $inputName;
                }
            }
            $rules['subscriptions_types_checkboxes'] = ['required', new CustomCheckboxValidationRule($subscriptionsTypesArray, $amountsArray)];
            $rules['subscriptions_types_checkboxes.*'] = 'integer';
        }
        

        return $rules;
    }

    public function messages()
    {
        return [
            // name
            'name_ar.required' => 'Name AR is required !!',
            'name_en.required' => 'Name EN is required !!',

            // type
            'type.required' => 'Type is required !!',
            'type.numeric' => 'Type must be of type numeric !!',
            'type.integer' => 'Type must be of type integer !!',
            'type.in' > 'Type value is not valid !!',

            // customer_id
            'customer_id.required' => 'Customer is required !!',
            'customer_id.numeric' => 'Customer must be of type numeric !!',
            'customer_id.integer' => 'Customer must be of type integer !!',
            'customer_id.in' => 'Customer is not valid',

            // project_salesman
            'project_salesman.required' => 'Project salesman is required !!',
            'project_salesman.numeric' => 'Project salesman must be of type numeric !!',
            'project_salesman.integer' => 'Project salesman must be of type integer !!',
            'project_salesman.in' => 'Sales man is not valid',

            // title and file
            'title.required' => 'Project Contract Title is required !!',
            'title.file' => 'Project Contract File is required !!',
            'title.mimes' => 'Project Contract File is not valid !!',


            // total_contracts
            'total_contracts.numeric' => 'Total contracts must be of type numeric',
            'total_contracts.required' => 'Total contarct is required',
            'total_contracts.min' => 'Total contarct minimum value is 1',


            // total_support
            'total_support.numeric' => 'Total Support must be of type numeric',
            'total_support.required' => 'Total Support is required',
            'total_support.min' => 'Total Support minimum value is 1',

            // total_hosting
            'total_hosting.numeric' => 'Total Hosting must be of type numeric',
            'total_hosting.min' => 'Total Hosting minimum value is 1',

            // due_date_hosting
            'due_date_hosting.date' => 'Due Date Hosting must be of type date',
            'due_date_hosting.date_format' => 'Due Date Hosting format is not valid',

            // signing_date
            'signing_date.required' => 'Signing Date is required',
            'signing_date.date' => 'Signing Date must be of type date',
            'signing_date.date_format' => 'Signing Date format is not valid',

            // launch_date
            'launch_date.date' => 'Launch Date must be of type date',
            'launch_date.date_format' => 'Launch Date format is not valid',

            // due_date_support
            'due_date_support.date' => 'Due Date Support must be of type date',
            'due_date_support.date_format' => 'Due Date Support format is not valid',



            // customer_project_coordinator_phone
            'customer_project_coordinator_phone.required' => 'customer project coordinator phone is required',
            'customer_project_coordinator_phone.numeric' => 'customer project coordinator phone must be of type numeric',
            'country_phone_id.required' => 'Country Phone Code is required !!',
            'country_phone_id.numeric' => 'Country Phone Code must be a number !!',
            'country_phone_id.integer' => 'Country Phone Code must be an integer !!',
            'country_phone_id.required' => 'Country Phone Code is required !!',
            'country_phone_id.in' => 'Country Code is not valid',


            // array validation
            'payment_types.required' => 'The payment type is required.',
            'payment_types.*.required' => 'The payment type field is required for each entry.',
            'payment_types.*.integer' => 'The payment type must be an integer.',

            'payment_date.required' => 'The payment date is required.',
            'payment_date.*.required' => 'The payment date field is required for each entry.',
            'payment_date.*.date' => 'Invalid date format for payment dates.',
            'payment_date.*.date_format' => 'Invalid date format for payment dates.',

            'payment_amount.required' => 'The payment amount is required.',
            'payment_amount.*.required' => 'The payment amount field is required for each entry.',
            'payment_amount.*.numeric' => 'The payment amount must be numeric.',
            'payment_amount.*.min' => 'The payment amount must be at lease 1.',

            'payment_description.required' => 'The payment description is required.',
            'payment_description.*.required' => 'The payment description field is required for each entry.',
            'payment_description.*.string' => 'The payment description must be a string.',

            'payment_paid_amount.required' => 'The payment amount is required.',
            'payment_paid_amount.*.required' => 'The payment amount field is required for each entry.',
            'payment_paid_amount.*.numeric' => 'The payment amount must be numeric.',

            // ================= OTHER VALIDATIONS ================
            'phone_not_valid.required' => 'Customer Project Coordinator Phone is not valid',
            'total_payment_table.required' => 'The total payments must be equal to total contracts.'


        ];
    }
}
