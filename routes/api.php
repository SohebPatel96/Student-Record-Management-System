<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
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



Route::middleware('basic_auth')->group(function () {
    Route::prefix('student')->group(function () {
        Route::post('/store', [StudentController::class, 'store']);
        Route::get('/search/{text}', [StudentController::class, 'search']);
    });
});
