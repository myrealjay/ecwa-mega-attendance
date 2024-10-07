<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'attendance', 'middleware' => ['auth:sanctum']], function() {
    Route::get('', [AttendanceController::class, 'index'])->name('getAttendance');
    Route::get('all', [AttendanceController::class, 'fetchAttendance'])->name('fetchAllAttendance');
    Route::post('', [AttendanceController::class, 'store'])->name('markAttendance');
    Route::get('by-date', [AttendanceController::class, 'attendanceByDate'])->name('getByDate');
    Route::get('total-present', [AttendanceController::class, 'totalPresentLastSunday']);
    Route::get('total-absent', [AttendanceController::class, 'totalAbsentLastSunday']);
    Route::get('last4sundays', [AttendanceController::class, 'last4Sundays'])->name('getLast4Sundays');
});