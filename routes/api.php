<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post("auth/register", [AuthenticationController::class, 'register']);
Route::post("auth/login", [AuthenticationController::class, 'login']);
Route::post("auth/logout", [AuthenticationController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/products', ProductController::class);

    Route::apiResource('/orders', OrderController::class);

    Route::post('/orders/{order}/payments', [OrderController::class, 'processPayment']);
});