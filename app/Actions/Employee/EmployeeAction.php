<?php

namespace App\Actions\Employee;

use Illuminate\Http\Request;
use App\Actions\ActionMaster;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Employee\EmployeeRepoInterface;

class EmployeeAction extends ActionMaster
{
    protected EmployeeRepoInterface $employeeRepo;

    protected function __construct()
    {
        $this->employeeRepo = app(EmployeeRepoInterface::class);
    }

    /**
     * Get a list of Employees.
     *
     * @return object Returns an collection containing the list of Employees.
     */

    public function index()
    {
        $employees = $this->employeeRepo->index();
        
        return $employees;
    }

    /**
     * Get a specific Employee by ID.
     *
     * @param int $employee_id The ID of the Employee to retrieve.
     *
     * @return object Returns an object containing the Employee details.
     */

    public function show(string $employee_id): object
    {
        $employee = $this->employeeRepo->show($employee_id);

        return $employee;
    }

    /**
     * Create a new Employee.
     *
     * @param Request $request The HTTP request containing Employee data.
     *
     * @return Employee Returns a Employee object containing the created Employee details.
     */

    public function create(Request $request): Employee
    {
        $employee = $this->employeeRepo->create($request->all());

        return $employee;
    }

    /**
     * Update an existing Employee excluding password
     *
     * @param int $employee_id The ID of the Employee to update.
     * @param Request $request The HTTP request containing updated Employee data.
     *
     * @return object Returns an object containing the updated Employee details.
     */

    public function updateNonPassword(string $employee_id, Request $request): object
    {
        $employee = $this->employeeRepo->show($employee_id);

        $employee = $this->employeeRepo->update($employee, $request->all(), false);

        return $employee;
    }

    /**
     * Update an existing Employee's password only.
     *
     * @param int $employee_id The ID of the Employee to update.
     * @param Request $request The HTTP request containing updated Employee data.
     *
     * @return object Returns an object containing the updated Employee details.
     */

     public function updatePassword(string $employee_id, Request $request): object
     {
         $employee = $this->employeeRepo->show($employee_id);
 
         $employee = $this->employeeRepo->update($employee, $request->all(), true);
 
         return $employee;
     }

     /**
     * Delete an existing Employee
     *
     * @param int $employee_id The ID of the Employee to delete.
     */

    public function delete(string $employee_id): void
    {
        $employee = $this->employeeRepo->show($employee_id);
 
        $this->employeeRepo->delete($employee);

    }
}
