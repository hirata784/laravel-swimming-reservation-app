<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 一般
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('reservation', [ReservationController::class, 'index']);
Route::apiResource('timeslot', TimeSlotController::class);

Route::group([
    'middleware' => ['auth:api'],
    'prefix' => 'auth'
], function ($router) {
    // registerとloginは認証不要
    Route::post('register', [AuthController::class, 'register'])->withoutMiddleware(['auth:api']);
    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware(['auth:api']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh'])->withoutMiddleware(['auth:api']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('reservation', [ReservationController::class, 'store']);
    Route::delete('reservation', [ReservationController::class, 'destroy']);
    Route::put('profile', [UserController::class, 'updateProfile']);
    Route::put('user', [UserController::class, 'update']);
    Route::put('password', [PasswordController::class, 'update']);
});

// 管理者
Route::group([
    'middleware' => ['auth:admins'],
    'prefix' => 'admins'
], function ($router) {
    // loginは認証不要
    Route::post('login', [AdminController::class, 'login'])->withoutMiddleware(['auth:admins']);
    Route::post('logout', [AdminController::class, 'logout']);
    Route::get('me', [AdminController::class, 'me']);
});
