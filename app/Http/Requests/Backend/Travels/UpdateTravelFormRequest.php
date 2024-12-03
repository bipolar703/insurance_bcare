<?php

namespace App\Http\Requests\Backend\Travels;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTravelFormRequest extends FormRequest
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
            'title' => 'required',
            'date' => 'required|date',
            'user_id' => 'required|integer|numeric',
            'status' => 'required|integer|numeric',
            'distance' => 'required|numeric|min:0',
        ];
    }
}
