<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|Split the routes into different files inside userRoutes
|
*/

Route::group(['middleware' => ['throttle:api']], function () {
    foreach (glob(__DIR__ . '/ApiRoutes/*.php') as $file) {
        require $file;
    }
});

Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');
