<?php

namespace App\Http\Requests\Company;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
            'logo'        => ['nullable', 'file', 'mimes:jpeg,png', 'max:2048',],
        ];
    }
}
