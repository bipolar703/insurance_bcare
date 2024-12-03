<?php

namespace App\Http\Requests\Backend\Admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateAdminFormRequest extends FormRequest
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
        // dd($this->request);
        $rules = [
            'name'  => 'required',
            'email'  => 'required|email|unique:admins,email,' . $this->id,
            'phone' => 'required|numeric|unique:admins,phone,' . $this->id,
            'status' => 'required|numeric|integer',
            'type' => 'required|numeric|integer',
            'image' => 'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif,webp|max:5000',
            'password' => [
                Rule::requiredIf(function () {
                    return $this->filled('old_password');
                }),
                'nullable',
                'min:7',
                'confirmed',
            ],

        ];
        // Add password confirmation rule if password is provided
        if ($this->filled('password')) {
            $rules['password'][] = 'required';
        }

        return $rules;
    }
    public function messages()
    {
        return [

            // Names
            'name.required' => 'Name is required !!!',

            // Email
            'email.required' => 'Email is required !!!',
            'email.email' => 'Email must be valid !!!',
            'email.unique' => 'email is already used!!!',

            // Phone
            'phone.numeric' => 'Phone must be a number',
            'phone.required' => 'Phone is required',
            'phone.unique' => 'Phone must be unique!!!',

            // Password
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password is not confirmed',
            'password.min' => 'Minimum length for password is 8 character',

            // Status
            'status.numeric' => 'Status must be a number',
            'status.integer' => 'Status must be an integer',
            'status.required' => 'Status is required',

            // type
            'type.numeric' => 'type must be a number',
            'type.integer' => 'type must be an integer',
            'type.required' => 'type is required',

            //image
            'image.*' => 'accepted image must be of type image jpeg,png,gif,bmp,webp,svg,tiff,ico',
            'image.max' => 'max image size is 5mb',
            'image.required' => 'max is required',

            // old pass
            'old_password.password' => 'The old password is incorrect',
        ];
    }
}
