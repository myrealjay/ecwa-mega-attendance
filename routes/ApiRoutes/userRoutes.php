<?php

use App\Http\Controllers\AgeRestrictionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailCategoryController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\SmsTemplateController;
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

Route::group(['prefix' => 'users', 'middleware' => ['auth:sanctum'] ], function() {
    Route::get('', [UserController::class, 'index'])->name('users');
    Route::get('all', [UserController::class, 'getUsers'])->name('allUsers');
    Route::get('{id}', [UserController::class, 'show'])->name('getSingleUser');
});

Route::group(['prefix' => 'attendance', 'middleware' => ['auth:sanctum']], function() {
    Route::get('', [AttendanceController::class, 'index'])->name('getAttendance');
    Route::post('', [AttendanceController::class, 'store'])->name('markAttendance');
    Route::get('by-date', [AttendanceController::class, 'attendanceByDate'])->name('getByDate');
});

Route::group(['prefix' => 'email-categories', 'middleware' => ['auth:sanctum']], function() {
    Route::get('', [EmailCategoryController::class, 'index'])->name('getCategories');
    Route::post('', [EmailCategoryController::class, 'store'])->name('storeCategories');
});

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::group(['prefix' => 'email-templates'], function() {
        Route::get('', [EmailTemplateController::class, 'index'])->name('getTemplates');
        Route::post('', [EmailTemplateController::class, 'store'])->name('storeTemplates');
        Route::put('{id}', [EmailTemplateController::class, 'update'])->name('updateTemplates');
        Route::delete('{id}', [EmailTemplateController::class, 'delete'])->name('deleteTemplates');
    });

    Route::group(['prefix' => 'sms-templates'], function() {
        Route::get('', [SmsTemplateController::class, 'index'])->name('getTemplates');
        Route::post('', [SmsTemplateController::class, 'store'])->name('storeTemplates');
        Route::put('{id}', [SmsTemplateController::class, 'update'])->name('updateTemplates');
        Route::delete('{id}', [SmsTemplateController::class, 'delete'])->name('deleteTemplates');
    });

    Route::group(['prefix' => 'recipients'], function() {
        Route::get('', [RecipientController::class, 'index'])->name('getRecipients');
        Route::post('', [RecipientController::class, 'store'])->name('storeRecipients');
        Route::post('remove', [RecipientController::class, 'delete'])->name('deleteRecipients');
    });

    Route::get('emails', [EmailTemplateController::class, 'getEmails'])->name('getEmails');
    Route::post('sms', [EmailTemplateController::class, 'smsWebhook']);
});

