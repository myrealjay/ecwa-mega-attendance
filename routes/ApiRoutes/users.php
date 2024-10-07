<?php

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
    Route::put('user/{id}', [AuthController::class, 'update'])->middleware('auth:sanctum')->name('updateUser');
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

Route::group(['prefix' => 'users', 'middleware' => ['auth:sanctum'] ], function() {
    Route::get('roles', [UserController::class, 'getRoles'])->name('getRoles');
    Route::get('admins', [UserController::class, 'getAdmins'])->name('getAdmins');
    Route::get('', [UserController::class, 'index'])->name('users');
    Route::get('all', [UserController::class, 'getUsers'])->name('allUsers');
    Route::get('structure',  [UserController::class, 'getUserStructure']);
    Route::get('count', [UserController::class, 'count'])->name('getCountUsers');
    Route::get('{id}', [UserController::class, 'show'])->name('getSingleUser');
    Route::post('', [UserController::class, 'store'])->name('addUser');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('changePassword');
});

