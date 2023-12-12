<?php

namespace App\Routes\Employee;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Employee\EmployeeController;

class EmployeeViewRoute
{
    public static function V1()
    {
        Route::controller(EmployeeController::class)->group(function ()
        {
            Route::get('/list', 'list')->name('employee-index');
            Route::get('/form', 'form')->name('employee-form');
            Route::get('/edit/{employee_id}', 'edit')->name('employee-edit');
        });
    }
}