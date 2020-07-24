<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('ajax')->namespace('Ajax')->group(function(){
    Route::prefix('package')->group(function () {
        Route::get('list', 'PackageController@list');
        Route::get('{packageId}/days-of-weak', 'PackageController@daysOfWeak');
    });


    Route::post('/order/create', 'OrderController@create');
});
