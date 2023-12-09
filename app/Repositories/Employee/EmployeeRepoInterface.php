<?php


namespace App\Repositories\Employee;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface EmployeeRepoInterface
{
    public function index(): LengthAwarePaginator;
    public function show(int $employee_id): Employee;
    public function create(array $data): Employee;
    public function update(Employee $employee, array $data): Employee;
    public function delete(Employee $employee): void;

}