<?php


namespace App\Repositories\Company;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepoInterface
{
    public function index(): Collection;
    public function show(int $company_id): Company;
    public function create(array $data): Company;
    public function update(Company $company, array $data): Company;
    public function delete(Company $company): void;

}