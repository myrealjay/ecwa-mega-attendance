<?php

use App\Http\Controllers\AgeRestrictionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->middleware('auth:sanctum')->name('register');
    Route::post('resetlink', [AuthController::class, 'sendResetLink']);
    Route::get('/reset-password/{token}', function ($token) {
        return Redirect::away('/auth/change-password/'.$token);
    })->middleware('guest')->name('password.reset');

    Route::post('reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refreshToken');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

Route::group(['prefix' => 'users','middleware' => ['auth:sanctum'] ], function() {
    Route::get('', [UserController::class, 'index'])->name('users');
});

