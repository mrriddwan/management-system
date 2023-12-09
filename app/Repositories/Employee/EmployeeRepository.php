<?php

namespace App\Repositories\Employee;

use Exception;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository implements EmployeeRepoInterface
{

    public function index(): Collection
    {
        return Employee::all();
    }

    public function show(int $employee_id): Employee
    {
        return Employee::findOr($employee_id, fn () => throw new Exception("Employee not found", 404));
    }

    public function create(array $data): Employee
    {
        return Employee::create([
            'name' => $data['name'],
        ]);
    }

    public function update(Employee $employee, array $data): Employee
    {
        $employee->update([
            'name' => $data['name']
        ]);

        return $employee;
    }

    public function delete(Employee $employee): void
    {
        $employee->delete();
    }
}
