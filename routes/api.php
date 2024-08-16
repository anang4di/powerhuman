<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ResponsibilityController;
use App\Http\Controllers\Api\RoleController;
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

        // Role
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('', [RoleController::class, 'fetch'])->name('fetch');
            Route::post('', [RoleController::class, 'create'])->name('create');
            Route::post('update/{id}', [RoleController::class, 'update'])->name('update');
            Route::delete('{id}', [RoleController::class, 'destroy'])->name('delete');
        });

        // Responsilibity
        Route::prefix('responsibilities')->name('responsibilities.')->group(function () {
            Route::get('', [ResponsibilityController::class, 'fetch'])->name('fetch');
            Route::post('', [ResponsibilityController::class, 'create'])->name('create');
            Route::delete('{id}', [ResponsibilityController::class, 'destroy'])->name('delete');
        });

        // Employee
        Route::prefix('employees')->name('employees.')->group(function () {
            Route::get('', [EmployeeController::class, 'fetch'])->name('fetch');
            Route::post('', [EmployeeController::class, 'create'])->name('create');
            Route::post('update/{id}', [EmployeeController::class, 'update'])->name('update');
            Route::delete('{id}', [EmployeeController::class, 'destroy'])->name('delete');
        });
    });
});
