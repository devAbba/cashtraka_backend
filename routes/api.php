<?php

use App\Http\Controllers\CashTransactionController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/transactions', [CashTransactionController::class, 'index']);

    Route::post('/transactions', [CashTransactionController::class, 'store']);

    Route::delete('/transactions/{transaction}', [CashTransactionController::class, 'destroy']);
});


