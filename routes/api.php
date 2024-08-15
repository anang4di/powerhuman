<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::get('/me', [UserController::class, 'me']);
    });
});
