<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('verified', function () {
    return view('auth.verified');
});

Route::group(['prefix' => 'email', 'middleware' => ['auth:sanctum']], function () {
    Route::get('verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');
    
    Route::post('verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});
