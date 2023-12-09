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

    public function show(int $Company_id): Company
    {
        return Company::findOr($Company_id, fn () => throw new Exception("Company not found", 404));
    }

    public function create(array $data): Company
    {
        return Company::create([
            'name' => $data['name'],
        ]);
    }

    public function update(Company $Company, array $data): Company
    {
        $Company->update([
            'name' => $data['name']
        ]);

        return $Company;
    }

    public function delete(Company $Company): void
    {
        $Company->delete();
    }
}
