<?php

namespace App\Http\Controllers\Api\Company;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Company\CompanyAction;
use App\Http\Requests\Company\CompanyStoreRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Traits\Response\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try
        {
            $companies = CompanyAction::access()->index();

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully retrieved all companies',
                CompanyResource::collection($companies),
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

            $company = CompanyAction::access()->create($request->all());

            DB::commit();

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully store new company',
                new CompanyResource($company),
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
    public function show(string $company_id)
    {
        try
        {
            $company = CompanyAction::access()->show($company_id);

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully retrieved all companies',
                new CompanyResource($company),
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
    public function edit(string $company_id)
    {
        try
        {
            DB::beginTransaction();

            // $companies = CompanyAction::access()->create($company_id);

            DB::commit();

            // return $this->success(
            //     Response::HTTP_ACCEPTED,
            //     'Successfully retrieved all companies',
            //     CompanyResource::collection($companies),
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
    public function update(CompanyUpdateRequest $request, string $company_id)
    {
        try
        {
            DB::beginTransaction();

            $company = CompanyAction::access()->update($company_id, $request->all());

            DB::commit();

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully update selected company',
                new CompanyResource($company),
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
    public function destroy(string $company_id)
    {
        try
        {
            DB::beginTransaction();

            $company = CompanyAction::access()->delete($company_id);

            DB::commit();

            return $this->success(
                Response::HTTP_ACCEPTED,
                'Successfully deleted selected company',
                new CompanyResource($company),
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return $this->error(Response::HTTP_CONFLICT, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}
