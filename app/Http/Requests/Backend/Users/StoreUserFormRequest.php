<?php

namespace App\Http\Requests\Backend\Users;

use App\Models\Department;
use App\Models\EmployeeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class StoreUserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    //
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    //  ============================================ EDITED BY RAGHAD ============================================
    
    public function rules()
    {
        $departmentsArray = Department::where('status', '=', '1')->pluck('id')->toArray();
        $statusArray = [1, 2]; // 1 => Active, 2 => Inactive

        $typeArray = EmployeeType::status(1)->pluck('id');

        $genderArray = [1, 2]; // 1 => Male, 2 => Female
        $MaritalStatusArray = [1, 2, 3, 4]; // 1 => Single, 2 => Married, 3 => Divorced, 4 => Widow/Widower
        $countriesArray = range(1, 250); // Each numer represent a contry and its data
        $citiesArray = range(1,5038); // // Each numer represent a city
        
        $rules =  [
            'name'  => 'required',
            'email'  => 'required|email|unique:users,email',
            'employee_type_id' => ['required', 'numeric' ,'integer', Rule::in($typeArray)],
            'password' => ['required', Password::min(7)->mixedCase()->numbers()->symbols(), 'confirmed'],
            'password_confirmation' => 'required|same:password',
            'status' => ['required','numeric', 'integer',  Rule::in($statusArray)],
            'work_email'  => 'nullable|email',
            'gender' => ['required', 'numeric' ,'integer', Rule::in($genderArray)],
            'marital_status' => ['required','numeric', 'integer', Rule::in($MaritalStatusArray)],
            'country_id' => ['required', 'numeric', 'integer', Rule::in($countriesArray)],
            'city_id' => ['required','numeric','integer',Rule::in($citiesArray)],
            'nationality' => ['required', 'numeric', 'integer', Rule::in($countriesArray)],
            'department_id' => ['required', 'numeric', 'integer', Rule::in($departmentsArray)],
            'salary' => 'nullable|numeric',
            'date_of_birth' => 'required|date|date_format:Y-m-d|before_or_equal:' . now()->subYears(19)->format('Y-m-d'),
            'date_of_hiring' => 'required|date|date_format:Y-m-d',
            'date_termination' => 'nullable|date|date_format:Y-m-d',
            'address'  => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif,tiff,tif,webp',
            'country_phone_id' => ['required','numeric', 'integer', Rule::in($countriesArray)],
            
        ];


          // The phone and country_phone_id are unique
          $rules['phone'] = [ 'required', 'numeric', 'integer' ,'min:0',
          Rule::unique('users')->where(function ($query) {
              return $query->where('country_phone_id', request('country_phone_id'));
          }),
          'regex:/^[\d]{5,15}$/']; // Note: Keep [] on regex validation, there is a case here

        //   work phone & work phone id
          if (isset($this->work_phone) || isset($this->work_country_phone_id)) {
            $rules['work_phone'] = 'required|numeric|integer|min:0';
            $rules['work_country_phone_id'] = ['required','numeric','integer',Rule::in($countriesArray)];

          }
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required !!',

            'email.required' => 'Email is required !!',
            'email.email' => 'Email must be valid !!',
            'email.unique' => 'Email is already exists !!',

            'phone.required' => 'Phone is required !!',
            'phone.integer' => 'Phone must be an integer !!',
            'phone.unique' => 'Phone is already exists !!',
            'phone.min' => 'Phone must be at least 0 !!',

            'country_phone_id.required' => 'Country Phone is required !!',
            'country_phone_id.integer' => 'Country Phone must be an integer !!',
            'country_phone_id.numeric' => 'Country Phone must be must be a number !!',
            'country_phone_id.in' => 'Country Phone ID is not valid !!', 

            'employee_type_id.required' => 'User Type is required !!',
            'employee_type_id.integer' => 'User Type must be an integer !!',
            'employee_type_id.in' => 'Type value is not valid',

            'department_id.required' => 'department id is required !!',
            'department_id.integer' => 'department id must be an integer !!',

            'password.required' => 'Password is required !!',
            'password.min' => 'Minimum length for password is 8 character !!',

            'password_confirmation.required' => 'Confirmation Password is required !!',
            'password_confirmation.same' => 'Password does not match !!',

            'status.integer' => 'Status must be an integer !!',
            'status.required' => 'Status is required !!',
            'status.numeric' => 'Status must be a number !!',
            'status.in' => 'Status value is not valid !!',

            'gender.required' => 'Gender is required !!',
            'gender.integer' => 'Gender must be an integer !!',
            'gender.numeric' => 'Gender must be a number !!',
            'gender.in' => 'Gender value is not valid !!',

            'marital_status.required' => 'Marital Status is required !!',
            'marital_status.integer' => 'Marital Status must be an integer !!',
            'marital_status.numeric' => 'Marital Status must be a number !!',
            'marital_status.in' => 'Marital Status value is not valid !!',

            'country_id.required' => 'Country ID is required !!',
            'country_id.integer' => 'Country ID must be an integer !!',
            'country_id.numeric' => 'Country ID must be a number !!',
            'country_id.in' => 'Country value is not valid',

            'city_id.required' => 'City ID is required !!',
            'city_id.integer' => 'City ID must be an integer !!',
            'city_id.numeric' => 'City ID must be a number !!',
            'city_id.in' => 'City ID value is not valid !!',

            'nationality.required' => 'Nationality is required !!',
            'nationality.integer' => 'Nationality must be an integer !!',
            'nationality.numeric' => 'Nationality must be a number !!',
            'nationality.in' => 'Nationality is not valid !!',

            'department_id.required' => 'Department ID is required !!',
            'department_id.integer' => 'Department ID must be an integer !!',
            'department_id.numeric' => 'Department ID must be a number !!',
            'department_id.in' => 'Department ID is not valid !!',

            'salary.numeric' => 'Salary must be a number !!',

            'date_of_birth.required' => 'Date of birth is required !!',
            'date_of_birth.date' => 'Date of birth must be a valid date !!',
            'date_of_birth.before_or_equal' => 'The employee old must be 19 years at least',
            'date_of_birth.date_format' => 'Date of birth must be a valid date !!',

            'date_of_hiring.required' => 'Date of hiring is required !!',
            'date_of_hiring.date' => 'Date of hiring must be a valid date !!',
            'date_of_hiring.date_format' => 'Date of hiring must be a valid date !!',
            
            'date_termination.date' => 'Date termination must be a valid date !!',
            'date_termination.date_format' => 'Date termination must be a valid date !!',
           
            'address.required'  => 'Address is required',

            'image.mimes' => 'Image type must be jpeg,jpg,png,gif,tiff,tif or webp !!',

            'work_phone.required' => 'Work Phone is required !!',
            'work_phone.integer' => 'Work Phone must be an integer !!',
            'work_phone.numeric' => 'Work Phone must be must be a number !!',
            'work_phone.min' => 'Work phone must be at least 0 !!',
            'work_country_phone_id.in' => 'Work Country Phone ID value is not valid',

            'work_country_phone_id.required' => 'Country Phone is required !!',
            'work_country_phone_id.integer' => 'Country Phone must be an integer !!',
            'work_country_phone_id.numeric' => 'Country Phone must be must be a number !!',

            'work_email.email' => 'Work Email must be valid !!',
            'work_email.unique' => 'Work Email is already exists !!',

        ];
    }
}
