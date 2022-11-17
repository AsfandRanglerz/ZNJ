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
    Route::post('user-login', 'AuthController@login');
    Route::post('social-login','AuthController@userSocialLogin');
    Route::post('forget-password','AuthController@forgetPassword');
    Route::post('confirm-token','AuthController@confirmToken');
    Route::post('submit-reset-password','AuthController@submitResetPassword');



    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('user-location','AuthController@userLocation');
        Route::get('edit-profile','AuthController@editProfile');
        Route::post('update-profile','AuthController@updateProfile');
        Route::post('create-event','EventController@createEvent');
        Route::post('create-entertainer','EventController@createEvent');
        Route::get('term-of-use','HomeController@terms');
    });
});
