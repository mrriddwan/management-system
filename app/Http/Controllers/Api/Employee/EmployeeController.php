<?php

namespace App\Http\Controllers\Api\Employee;

use Throwable;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Actions\Company\CompanyAction;
use App\Traits\Response\ResponseTrait;
use App\Actions\Employee\EmployeeAction;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Requests\Employee\EmployeeUpdateRequest;

class EmployeeController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try
        {
            $companies = EmployeeAction::access()->index();

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully retrieved all companies',
                EmployeeResource::collection($companies),
            );
        }
        catch (\Exception $e)
        {
            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Render a listing of the resource.
     */
    public function list(Request $request)
    {
        try
        {
            $employees = EmployeeAction::access()->index($request->page);

            return Inertia::render('Employee/Index', [
                'employees' => $employees,
            ]);
        }
        catch (\Exception | Throwable $e)
        {
            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function form(Request $request)
    {
        try
        {
            $companies = CompanyAction::access()->index();

            return Inertia::render('Employee/Form', [
                'companies' => $companies
            ]);
        }
        catch (\Exception | Throwable $e)
        {
            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $employee = EmployeeAction::access()->create($request->all());

            DB::commit();

            $employees = EmployeeAction::access()->index($request->page);

            return Inertia::render('Employee/Index', [
                'employees' => $employees,
            ]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $employee_id)
    {
        try
        {
            $employee = EmployeeAction::access()->show($employee_id);

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully retrieved all companies',
                new EmployeeResource($employee),
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $employee_id)
    {
        try
        {
            DB::beginTransaction();

            $employee = EmployeeAction::access()->show($employee_id);

            $companies = Company::all();

            return Inertia::render('Employee/Form', [
                'employee' => $employee,
                'companies' => $companies,
            ]);
        }
        catch (\Exception | Throwable $e)
        {
            DB::rollBack();

            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, string $employee_id)
    {
        try
        {
            DB::beginTransaction();

            $employee = EmployeeAction::access()->update($employee_id, $request->all());

            DB::commit();

            $employees = EmployeeAction::access()->index($request->page);

            return Inertia::render('Employee/Index', [
                'employees' => $employees,
            ]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $employee_id, Request $request)
    {
        try
        {
            DB::beginTransaction();

            $employee = EmployeeAction::access()->delete($employee_id);

            DB::commit();

            $employees = EmployeeAction::access()->index($request->page);

            return Inertia::render('Employee/Index', [
                'employees' => $employees,
            ]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}