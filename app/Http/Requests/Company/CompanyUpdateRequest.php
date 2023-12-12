<?php

namespace App\Http\Requests\Company;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompanyUpdateRequest extends FormRequest
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
        return [
            'name'        => ['nullable', 'string'],
            'email'       => ['nullable', 'email', Rule::unique('companies', 'email')->ignore(request('company_id'))],
            'website_url' => ['nullable', 'string'],
            'logo'        => ['nullable', 'file', 'mimes:jpeg,png', 'max:2048'],
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'status' => 'failed',
    //         'message' => 'Validation errors',
    //         'data'    => $validator->errors()
    //     ], 403));
    // }
}
