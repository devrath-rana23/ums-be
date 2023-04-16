<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(static function () {
    Route::group(['middleware' => ['auth:sanctum']], static function () {
        Route::get(
            "/employee",
            [App\Http\Controllers\Api\EmployeeController::class, 'index']
        )
            ->name('employee.list');
        Route::get(
            "/employee/edit/{id}",
            [App\Http\Controllers\Api\EmployeeController::class, 'edit']
        )
            ->name('employee.edit');
        Route::put(
            "/" . config('constants.api.employee_common_string'),
            [App\Http\Controllers\Api\EmployeeController::class, 'update']
        )
            ->name('employee.update');
        Route::post(
            "/employee",
            [App\Http\Controllers\Api\EmployeeController::class, 'store']
        )
            ->name('employee.store');
        Route::delete(
            "/" . config('constants.api.employee_common_string'),
            [App\Http\Controllers\Api\EmployeeController::class, 'destroy']
        )
            ->name('employee.destroy');
        Route::prefix('export-csv')->group(function () {
            Route::get('skill', [App\Http\Controllers\Api\ExportCsvController::class, 'exportSkills']);
            Route::get('role', [App\Http\Controllers\Api\ExportCsvController::class, 'exportRoles']);
            Route::get('employee', [App\Http\Controllers\Api\ExportCsvController::class, 'exportEmployees']);
        });
        Route::middleware([CheckAdmin::class])->group(function () {
            Route::apiResource("roles", App\Http\Controllers\Api\RoleController::class);
            Route::apiResource("skills", App\Http\Controllers\Api\SkillController::class);
        });
        Route::prefix('download')->group(function () {
            Route::get('list', [App\Http\Controllers\Api\DownloadCsvController::class, 'index']);
        });
    });
});
