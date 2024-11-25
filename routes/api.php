<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::middleware('selectAuthMiddleware')->group(function () {

    });
});
