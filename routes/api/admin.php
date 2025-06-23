<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




// start Auth 
Route::prefix('v1')->group(function () {

    Route::post('login', 'AuthController@login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('store', 'GenericModelController@store')->middleware('checkPermision:create');
    });

});