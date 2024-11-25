<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttachmemtController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatroomController;
use App\Http\Controllers\MemberChatroomController;


Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::middleware('selectAuthMiddleware')->group(function () {
        Route::apiResource('chatroom', ChatroomController::class)
        ->only(['index', 'store', 'show']);
        Route::apiResource('member', MemberChatroomController::class)
        ->only(['index', 'store']);


        Route::post('member/update',[MemberChatroomController::class, 'update']);
    });
    Route::apiResource('message', MessageController::class)
    ->only(['index', 'store']);
});
