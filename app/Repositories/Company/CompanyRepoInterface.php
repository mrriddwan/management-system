<?php


namespace App\Repositories\Company;

use App\Models\Company;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CompanyRepoInterface
{
    public function index($page): LengthAwarePaginator;
    public function indexNoPaginate(): Collection;
    public function show(int $company_id): Company;
    public function create(array $data, ?string $logo): Company;
    public function update(Company $company, array $data, ?string $logo): Company;
    public function delete(Company $company): void;

}