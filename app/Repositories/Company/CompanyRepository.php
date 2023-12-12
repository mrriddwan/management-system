<?php

namespace App\Repositories\Company;

use Exception;
use App\Models\Company;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository implements CompanyRepoInterface
{

    public function index($page): LengthAwarePaginator
    {
        return Company::paginate();
    }

    public function indexNoPaginate(): Collection
    {
        return Company::all();
    }

    public function show(int $company_id): Company
    {
        return Company::with('employees')->findOr($company_id, fn () => throw new Exception("Company not found", 404));
    }

    public function create(array $data, ?string $logo): Company
    {
        return Company::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'website_url' => $data['website_url'],
            'logo'        => $logo,
        ]);
    }

    public function update(Company $company, array $data, ?string $logo): Company
    {
        $company->update([
            'name'        => $data['name'] ?? $company->name,
            'email'       => $data['email'] ?? $company->email,
            'website_url' => $data['website_url'] ?? $company->website_url,
            'logo'        => $logo ?? $company->logo,
        ]);

        return $company;
    }

    public function delete(Company $company): void
    {
        $company->delete();
    }
}
