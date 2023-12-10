<?php

namespace App\Repositories\Company;

use Exception;
use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository implements CompanyRepoInterface
{

    public function index(): LengthAwarePaginator
    {
        return Company::paginate();
    }

    public function show(int $company_id): Company
    {
        return Company::with('employees')->findOr($company_id, fn () => throw new Exception("Company not found", 404));
    }

    public function create(array $data, ?string $logo): Company
    {
        // dd($data['name']);
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
            'name'        => $data['name'],
            'email'       => $data['email'],
            'website_url' => $data['website_url'],
            'logo'        => $logo,
        ]);

        return $company;
    }

    public function delete(Company $company): void
    {
        $company->delete();
    }
}
