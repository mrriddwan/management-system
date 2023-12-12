<?php

namespace App\Repositories\Employee;

use Exception;
use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository implements EmployeeRepoInterface
{

    public function index(): LengthAwarePaginator
    {
        return Employee::with('company')->latest('id')->paginate();
    }

    public function show(int $employee_id): Employee
    {
        return Employee::findOr($employee_id, fn () => throw new Exception("Employee not found", 404));
    }

    public function create(array $data): Employee
    {
        return Employee::create([
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $data['email'],
            'phone_number' => $data['phone_number'],
            'company_id'   => $data['company_id'],
        ]);
    }

    public function update(Employee $employee, array $data): Employee
    {
        $employee->update([
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $data['email'],
            'phone_number' => $data['phone_number'],
            'company_id'   => $data['company_id'],
        ]);

        return $employee;
    }

    public function delete(Employee $employee): void
    {
        $employee->delete();
    }
}
