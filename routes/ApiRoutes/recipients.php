<?php

use App\Http\Controllers\RecipientController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::group(['prefix' => 'recipients'], function() {
        Route::get('', [RecipientController::class, 'index'])->name('getRecipients');
        Route::post('', [RecipientController::class, 'store'])->name('storeRecipients');
        Route::post('remove', [RecipientController::class, 'delete'])->name('deleteRecipients');
    });
});