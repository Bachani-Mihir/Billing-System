<?php

use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

    // Authentication
    //----------------------------------

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [RegisterController::class, 'store']);

    Route::post('/login', [SessionController::class, 'valid']);
});

    // Invoices
    //----------------------------------

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('invoices', InvoicesController::class);
});
