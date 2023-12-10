<?php

namespace App\Http\Controllers\Api\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Actions\Employee\EmployeeAction;
use App\Traits\Response\ResponseTrait;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully store new Employee',
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

            // $companies = EmployeeAction::access()->create($employee_id);

            DB::commit();

            // return $this->success(
            //     Response::HTTP_ACCEPTED,
            //     'Successfully retrieved all companies',
            //     EmployeeResource::collection($companies),
            // );
        }
        catch (\Exception $e)
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

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully update selected Employee',
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $employee_id)
    {
        try
        {
            DB::beginTransaction();

            $employee = EmployeeAction::access()->delete($employee_id);

            DB::commit();

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully deleted selected Employee',
                new EmployeeResource($employee),
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}