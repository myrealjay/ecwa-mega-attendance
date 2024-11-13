<?php

use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'events'], function() {
    Route::get('', [ProgramController::class, 'index'])->name('getEvents');
    Route::get('all', [ProgramController::class, 'getAll'])->name('getALlEvents');
    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::post('', [ProgramController::class, 'store'])->name('storeEvents');
        Route::post('remove/{id}', [ProgramController::class, 'delete'])->name('deleteEvents');
    });
});
