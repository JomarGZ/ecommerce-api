<?php

use App\Http\Controllers\Api\Auth\AuthenticatedUserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', AuthenticatedUserController::class)->middleware('auth:sanctum');

Route::post('auth/register', RegisterController::class);
Route::post('auth/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('auth/logout', LogoutController::class);
});