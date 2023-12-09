<?php

namespace App\Http\Controllers\Api\Company;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Company\CompanyAction;
use App\Http\Resources\Company\CompanyResource;
use App\Traits\Response\ResponseTrait;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
