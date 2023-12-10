<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'name'        => ['required', 'string'],
            'email'       => ['required', 'email', 'unique:companies'],
            'website_url' => ['required', 'string'],
            'logo'        => ['required', 'file', 'mimes:jpeg,png', 'max:2048',],
        ];
    }
}
