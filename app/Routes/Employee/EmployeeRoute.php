<?php

namespace App\Routes\Employee;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Employee\EmployeeController;

class EmployeeRoute
{
    public static function V1()
    {
        return Route::controller(EmployeeController::class)->group(function ()
        {
            //Resource
            Route::get('/', 'index');
            Route::get('/{employee_id}', 'show');
            Route::post('/create', 'store');
            Route::post('/update/{employee_id}', 'update');
            Route::delete('/delete/{employee_id}', 'destroy');
        });
    }
}