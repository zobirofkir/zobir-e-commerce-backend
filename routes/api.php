<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/**
 * Create Register Route
 */
Route::post("auth/register", [AuthenticationController::class, 'register']);

/**
 * Create Login Route
 */
Route::post("auth/login", [AuthenticationController::class, 'login']);

/**
 * Create Logout Route
 */
Route::post("auth/logout", [AuthenticationController::class, 'logout']);

/**
 * Create Authenticated Routes
 */
Route::middleware('auth:api')->group(function () {
    /**
     * Create Category Routes
     */
    Route::apiResource('/categories', CategoryController::class);

    /**
     * Create Product Routes
     */
    Route::apiResource('/products', ProductController::class);

    /**
     * Create Order Routes
     */
    Route::apiResource('/orders', OrderController::class);

    /**
     * Create Payment Routes
     */
    Route::post('/orders/{order}/payments', [PaymentController::class, 'processPayment']);

    /**
     * Create Brand Routes
     */
    Route::apiResource('/brands', BrandController::class);

});