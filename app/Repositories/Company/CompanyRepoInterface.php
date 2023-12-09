<?php


namespace App\Repositories\Company;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

interface CompanyRepoInterface
{
    public function index(): LengthAwarePaginator;
    public function show(int $company_id): Company;
    public function create(array $data): Company;
    public function update(Company $company, array $data): Company;
    public function delete(Company $company): void;

}