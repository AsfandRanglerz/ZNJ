<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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




Route::group(['namespace' => 'Api'], function () {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('forget-password','AuthController@forgetPassword');
    Route::post('confirm-token','AuthController@confirmToken');
    Route::post('submit-reset-password','AuthController@submitResetPassword');



    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', 'AuthController@logout');


    });
});
