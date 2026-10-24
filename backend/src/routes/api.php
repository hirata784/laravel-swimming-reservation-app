<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminRewardController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 誰でもアクセスできる共通ルート
Route::get('reservation', [ReservationController::class, 'index']);
Route::apiResource('timeslot', TimeSlotController::class);

// 一般ユーザー用（prefix: auth）のルート設定
Route::prefix('auth')->group(function () {
    // 【認証不要】のルート
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    // 【JWT認証必須（auth:api）】のルート群
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('reservation', [ReservationController::class, 'store']);
        Route::delete('reservation', [ReservationController::class, 'destroy']);
        Route::put('profile', [UserController::class, 'updateProfile']);
        Route::put('user', [UserController::class, 'update']);
        Route::put('password', [PasswordController::class, 'update']);
    });
});

// 管理者
Route::prefix('admins')->group(function () {
    // 【認証不要】のルート
    Route::post('login', [AdminController::class, 'login']);
    // 【管理者用JWT認証必須（auth:admins）】のルート群
    Route::middleware('auth:admins')->group(function () {
        Route::post('logout', [AdminController::class, 'logout']);
        Route::get('me', [AdminController::class, 'me']);
        Route::get('reservation/date/{firstDate}', [AdminReservationController::class, 'index']);
        Route::get('reservation/time-slots/{timeSlotId}', [AdminReservationController::class, 'show']);
        Route::put('reservation/{reservationId}', [AdminReservationController::class, 'update']);
        Route::get('user', [AdminUserController::class, 'index']);
        Route::get('user/{userId}', [AdminUserController::class, 'show']);
        Route::get('user/{userId}/rewards', [AdminUserController::class, 'showRewards']);
        Route::post('user/{userId}/rewards/update', [AdminRewardController::class, 'exchange']);
        Route::get('reward-items', [AdminRewardController::class, 'index']);
        Route::get('reward-items/available', [AdminRewardController::class, 'availableItems']);
    });
});
