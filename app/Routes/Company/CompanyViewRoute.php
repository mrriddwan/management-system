<?php

namespace App\Routes\Company;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Company\CompanyController;

class CompanyViewRoute
{
    public static function V1()
    {
        Route::controller(CompanyController::class)->group(function ()
        {
            Route::get('/list', 'list')->name('company-index');
            Route::get('/form', 'form')->name('company-form');
            Route::get('/edit/{company_id}', 'edit')->name('company-edit');
        });
    }
}