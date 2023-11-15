<?php

use App\Http\Controllers\User\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('user.register');
    Route::post('/auth', [AuthController::class, 'auth'])->name('user.auth');
});

