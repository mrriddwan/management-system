<?php

namespace App\Http\Requests\Employee;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'email'        => ['nullable', 'email',  Rule::unique('employees')->ignore(request('employee_id'))],
            'phone_number' => ['nullable', 'between:10,12'],
            'company_id'   => ['nullable', 'integer'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'failed',
            'message' => 'Validation errors',
            'data'    => $validator->errors()
        ], 403));
    }
}
