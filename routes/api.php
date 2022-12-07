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
        Route::post('event-select-package','EventController@EventSelectPackage');

        Route::post('create-entertainer','EntertainerController@createEntertainer');
        Route::get('entertainers','EntertainerController@getEntertainer');
        Route::get('entertainer/{id}','EntertainerController@getSingleEntertainer');
        Route::post('update-entertainer/{id}','EntertainerController@updateEntertainer');
        Route::get('entertainer-price-package/{id}','EntertainerController@getEntertainerPricePackage');
        Route::get('entertainer-feature-packages','EntertainerController@getEntertainerFeaturePackages');
        Route::post('entertainer-select-package','EntertainerController@EntertainerSelectPackage');

        Route::get('venues','VenueController@getVenues');
        Route::get('venue/{id}','VenueController@getSingleVenue');
        Route::post('create-venue','VenueController@createVenue');
        Route::get('delete-venue/{id}','VenueController@destroy');
        Route::get('edit-venue/{id}','VenueController@editVenue');
        Route::post('update-venue/{id}','VenueController@updateVenue');
        Route::get('venue-feature-packages','VenueController@getVenueFeaturePackages');
        Route::post('venue-select-package','VenueController@VenueSelectPackage');


        Route::get('venues-reviews','ReviewController@getVenuesReviews');
        Route::get('venue-review/{id}','ReviewController@getSingleVenueReview');
        Route::get('events-reviews','ReviewController@getEventsReviews');
        Route::get('event-review/{id}','ReviewController@getSingleEventReview');
        Route::get('entertainers-reviews','ReviewController@getEntertainersReviews');
        Route::get('entertainer-review/{id}','ReviewController@getSingleEntertainerReview');
        Route::post('create-review','ReviewController@createReviews');



        Route::get('home-page','HomeController@HomePage');
        Route::get('top-rated-events','HomeController@topRatedEvents');
        Route::get('top-rated-entertainers','HomeController@topRatedEntertainers');
        Route::get('top-rated-venues','HomeController@topRatedVenues');
        Route::get('term-of-use','HomeController@terms');

        Route::post('search-data','SearchController@searchData');
        Route::post('search-filter','SearchController@searchFilter');
        Route::post('my-ads-filter','SearchController@myAdsFilter');
    });
});
