<?php

namespace App\Actions\Company;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Actions\ActionMaster;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Company\CompanyRepoInterface;

class CompanyAction extends ActionMaster
{
    protected CompanyRepoInterface $companyRepo;

    protected function __construct()
    {
        $this->companyRepo = app(CompanyRepoInterface::class);
    }

    /**
     * Get a list of Companys.
     *
     * @return object Returns an collection containing the list of Companys.
     */

    public function index()
    {
        $companys = $this->companyRepo->index();
        
        return $companys;
    }

    /**
     * Get a specific Company by ID.
     *
     * @param int $company_id The ID of the Company to retrieve.
     *
     * @return object Returns an object containing the Company details.
     */

    public function show(string $company_id): object
    {
        $company = $this->companyRepo->show($company_id);

        return $company;
    }

    /**
     * Create a new Company.
     *
     * @param Request $request The HTTP request containing Company data.
     *
     * @return Company Returns a Company object containing the created Company details.
     */

    public function create(Request $request): Company
    {
        $company = $this->companyRepo->create($request->all());

        return $company;
    }

    /**
     * Update an existing Company excluding password
     *
     * @param int $company_id The ID of the Company to update.
     * @param Request $request The HTTP request containing updated Company data.
     *
     * @return object Returns an object containing the updated Company details.
     */

    public function update(string $company_id, Request $request): object
    {
        $company = $this->companyRepo->show($company_id);

        $company = $this->companyRepo->update($company, $request->all());

        return $company;
    }

     /**
     * Delete an existing Company
     *
     * @param int $company_id The ID of the Company to delete.
     */

    public function delete(string $company_id): void
    {
        $company = $this->companyRepo->show($company_id);
 
        $this->companyRepo->delete($company);

    }
}
