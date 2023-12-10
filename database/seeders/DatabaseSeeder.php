<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Company\CompanySeeder;
use Database\Seeders\Employee\EmployeeSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this -> call([
            UserSeeder::class,
            CompanySeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
