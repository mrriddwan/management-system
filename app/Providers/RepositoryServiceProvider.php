<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Employee Repository
        $this->app->bind(\App\Repositories\Employee\EmployeeRepoInterface::class, \App\Repositories\Employee\EmployeeRepository::class);

        // Management Repository
        $this->app->bind(\App\Repositories\Company\CompanyRepoInterface::class, \App\Repositories\Company\CompanyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
