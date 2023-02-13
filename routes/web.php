<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api/v1')->group(static function () {
    Route::get('auth', [AuthController::class, 'index'])
        ->name('auth.index');
    Route::post('auth/callback', [AuthController::class, 'callback'])
        ->name('auth.callback');
    Route::post('auth/logout', [AuthController::class, 'logout'])
        ->name('auth.logout');
});
