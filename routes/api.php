<?php

use App\Http\Controllers\Chat\MessageController;
use App\Http\Controllers\User\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('user.register');
        Route::post('/auth', [AuthController::class, 'auth'])->name('user.auth');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('user.logout');
    });

    Route::apiResource('/messages', MessageController::class)->middleware('auth:sanctum');
});

