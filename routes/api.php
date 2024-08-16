<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {

    // Auth
    Route::name('auth.')->group(function () {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/register', [UserController::class, 'register']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [UserController::class, 'logout']);
            Route::get('/me', [UserController::class, 'me']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        // Company
        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('', [CompanyController::class, 'index']);
            Route::post('/update', [CompanyController::class, 'update']);
        });

        // Team
        Route::prefix('teams')->name('teams.')->group(function () {
            Route::get('', [TeamController::class, 'fetch'])->name('fetch');
            Route::post('', [TeamController::class, 'create'])->name('create');
            Route::post('update/{id}', [TeamController::class, 'update'])->name('update');
            Route::delete('{id}', [TeamController::class, 'destroy'])->name('delete');
        });
    });
});
