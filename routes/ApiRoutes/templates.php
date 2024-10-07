<?php

use App\Http\Controllers\EmailCategoryController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SmsTemplateController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::group(['prefix' => 'email-templates'], function() {
        Route::get('', [EmailTemplateController::class, 'index'])->name('getTemplates');
        Route::post('', [EmailTemplateController::class, 'store'])->name('storeTemplates');
        Route::put('{id}', [EmailTemplateController::class, 'update'])->name('updateTemplates');
        Route::delete('{id}', [EmailTemplateController::class, 'delete'])->name('deleteTemplates');
    });

    Route::group(['prefix' => 'sms-templates'], function() {
        Route::get('', [SmsTemplateController::class, 'index'])->name('getSmsTemplates');
        Route::post('', [SmsTemplateController::class, 'store'])->name('storeSmsTemplates');
        Route::put('{id}', [SmsTemplateController::class, 'update'])->name('updateSmsTemplates');
        Route::delete('{id}', [SmsTemplateController::class, 'delete'])->name('deleteSmsTemplates');
    });

    Route::get('emails', [EmailTemplateController::class, 'getEmails'])->name('getEmails');
    Route::post('sms', [EmailTemplateController::class, 'smsWebhook']);
});

Route::group(['prefix' => 'email-categories', 'middleware' => ['auth:sanctum']], function() {
    Route::get('', [EmailCategoryController::class, 'index'])->name('getCategories');
    Route::post('', [EmailCategoryController::class, 'store'])->name('storeCategories');
});

Route::post('send-custom-messages', [MessageController::class, 'sendCustomMessage'])->name('sendCustomMessage');