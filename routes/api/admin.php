<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




// start Auth 
Route::prefix('v1')->middleware('ckeckLang')->group(function () {

    Route::post('login', 'AuthController@login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('store', 'CrudController@store')->middleware('checkPermision:create');
    });
    

});