<?php

namespace App\Routes\Company;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Company\CompanyController;

class CompanyAPIRoute
{
    public static function V1()
    {
        Route::controller(CompanyController::class)->group(function ()
        {
            Route::get('/', 'index');
            Route::get('/{company_id}', 'show');
            Route::post('/store', 'store');
            Route::post('/update/{company_id}', 'update');
            Route::delete('/delete/{company_id}', 'destroy');
        });
    }
}