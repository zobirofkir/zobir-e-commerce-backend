<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("auth/register", [AuthenticationController::class, 'register']);
Route::post("auth/login", [AuthenticationController::class, 'login']);
Route::post("auth/logout", [AuthenticationController::class, 'logout']);