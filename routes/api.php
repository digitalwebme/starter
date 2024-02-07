<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\PostVisitController;
use App\Http\Controllers\API\PreVisitController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ReportController;

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

Route::middleware('prevent-back-history')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('change-password', [AuthController::class, 'updatePassword']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
});