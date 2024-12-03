<?php

namespace App\Http\Requests\Backend\CertifiedChecks;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertifiedChecksFormRequest extends FormRequest
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
            'customer_id' => 'required|numeric|integer',
            'reason_for_release' => 'required|numeric|integer',
            'status' => 'required|numeric|integer',
            'check_number' => 'required|numeric|unique:certified_checks,check_number',
            'release_to' => 'required',
            'amount' => 'required|numeric',
            'release_date' => 'required|date',
            'image' => 'required|mimes:png,jpg,webp,jpeg,gif,svg',
        ];
    }
}
