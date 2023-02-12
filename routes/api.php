<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("roles", App\Http\Controllers\Api\RoleController::class);
Route::apiResource("skills", App\Http\Controllers\Api\SkillController::class);
Route::get("/employee", [App\Http\Controllers\Api\EmployeeController::class, 'index'])->name('employee.list');
Route::get("/employee/{$id}", [App\Http\Controllers\Api\EmployeeController::class, 'show'])->name('employee.details');
Route::get("/employee/edit/{$id}", [App\Http\Controllers\Api\EmployeeController::class, 'edit'])->name('employee.edit');
Route::put("/employee/{$id}", [App\Http\Controllers\Api\EmployeeController::class, 'update'])->name('employee.update');
Route::get("/employee/create/{$id}", [App\Http\Controllers\Api\EmployeeController::class, 'create'])->name('employee.create');
Route::post("/employee/{$id}", [App\Http\Controllers\Api\EmployeeController::class, 'store'])->name('employee.store');
Route::delete("/employee/{$id}", [App\Http\Controllers\Api\EmployeeController::class, 'destroy'])->name('employee.destroy');
