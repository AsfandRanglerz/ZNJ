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
        Route::get('events','EventController@getEvents');
        Route::get('user-events','EventController@userEvents');
        Route::post('event','EventController@getEvent');
        Route::get('event_entertainer/{id}','EventController@getEventEntertainers');
        Route::post('update-event/{id}','EventController@updateEvent');
        Route::get('delete-event/{id}','EventController@destroy');
        Route::get('event-feature-packages','EventController@getEventFeaturePackages');
        Route::post('create-entertainer','EntertainerController@createEntertainer');
        Route::get('entertainers','EntertainerController@getEntertainer');
        Route::get('entertainer/{id}','EntertainerController@getSingleEntertainer');
        Route::post('update-entertainer/{id}','EntertainerController@updateEntertainer');
        Route::get('entertainer-price-package/{id}','EntertainerController@getEntertainerPricePackage');
        Route::get('entertainer-feature-packages','EntertainerController@getEntertainerFeaturePackages');
        Route::get('venues','VenueController@getVenues');
        Route::get('venue/{id}','VenueController@getSingleVenue');
        Route::post('create-venue','VenueController@createVenue');
        Route::get('delete-venue/{id}','VenueController@destroy');
        Route::get('edit-venue/{id}','VenueController@editVenue');
        Route::post('update-venue/{id}','VenueController@updateVenue');
        Route::get('venue-feature-packages','VenueController@getVenueFeaturePackages');
        Route::get('term-of-use','HomeController@terms');


    });
});
