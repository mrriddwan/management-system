<?php

namespace App\Http\Requests\Employee;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'first_name'   => ['nullable', 'string'],
            'last_name'    => ['nullable', 'string'],
            'email'        => ['nullable', 'email',  Rule::unique('employees', 'email')->ignore(request('employee_id'))],
            'phone_number' => ['nullable', 'between:10,12'],
            'company_id'   => ['nullable', 'integer'],
        ];
    }
}
