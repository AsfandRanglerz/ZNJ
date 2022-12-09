<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\TeamAController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\RecruiterController;
use App\Http\Controllers\Admin\IntrovideoController;
use App\Http\Controllers\Admin\EntertainerController;
use App\Http\Controllers\Admin\FeatureAdsPackagesController;
use App\Http\Controllers\Admin\NotificationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('Privacy-policy', [SecurityController::class, 'PrivacyPolicy']);

/*Admin routes
 * */
Route::get('/admin', [AuthController::class, 'getLoginPage']);
Route::post('/login', [AuthController::class, 'Login']);
Route::get('/admin-forgot-password', [AdminController::class, 'forgetPassword']);
Route::post('/admin-reset-password-link', [AdminController::class, 'adminResetPasswordLink']);
Route::get('/change_password/{id}', [AdminController::class, 'change_password']);
Route::post('/admin-reset-password', [AdminController::class, 'ResetPassword']);

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'getdashboard']);
    Route::get('profile', [AdminController::class, 'getProfile']);
    Route::post('update-profile', [AdminController::class, 'update_profile']);
    Route::post('update-password', [AdminController::class, 'profile_change_password'])->name('profile.change-password');

    Route::get('privacy-policy-edit', [SecurityController::class, 'PrivacyPolicyEdit']);
    Route::post('privacy-policy-update', [SecurityController::class, 'PrivacyPolicyUpdate']);
    Route::get('term-condition', [SecurityController::class, 'TermCondition']);
    Route::get('term-condition-edit', [SecurityController::class, 'TermConditionEdit']);
    Route::post('term-condition-update', [SecurityController::class, 'TermConditionUpdate']);
    Route::get('logout', [AdminController::class, 'logout']);
    // Users
    Route::get('/users/index', [UserController::class, 'index'])->name('admin.user.index');
    //Recruiter
    // Recruiter
    Route::resource('recruiter', RecruiterController::class)->parameters([
        'recruiter' => 'user_id'
    ]);
    Route::get('/recruiter/event/edit/{user_id}/event-id-{event_id}', [RecruiterController::class, 'editEventIndex'])->name('recruiter.event.edit.index');
    Route::post('/recruiter/event/update/event-id-{event_id}', [RecruiterController::class, 'updateEvent'])->name('recruiter.event.update');
    Route::get('/recruiter/event/delete/event-id-{event_id}', [RecruiterController::class, 'destroyEvent'])->name('recruiter.event.delete');
    Route::get('/recruiter/event/add/user-id-{event_id}', [RecruiterController::class, 'createEventIndex'])->name('recruiter.event.add.index');
    Route::post('/recruiter/event/add/user-id-{user_id}',[RecruiterController::class, 'storeEvent'])->name('recruiter.event.store');
    Route::get('/recruiter/event/entertainers/{user_id}/event-id-{event_id}',[RecruiterController::class, 'eventEntertainersIndex'])->name('recruiter.event_entertainers.index');
    Route::get('/recruiter/event/venues/{user_id}/event-id-{event_id}',[RecruiterController::class, 'eventVenuesIndex'])->name('recruiter.event_venues.index');


    //Entertainer
     Route::resource('entertainer', EntertainerController::class)->parameters([
        'recruiter' => 'user_id'
    ]);
     Route::get('/entertainer/talent/add/{user_id}',[EntertainerController::class,'createTalentIndex'])->name('entertainer.talent.add');
     Route::post('/entertainer/talent/store/{user_id}',[EntertainerController::class,'storeTalent'])->name('entertainer.talent.store');
     Route::get('/entertainer/talent/delete/{user_id}',[EntertainerController::class,'destroyTalent'])->name('entertainer.talent.delete');
     Route::get('/entertainer/talent/edit/{user_id}/{entertainer_details_id}',[EntertainerController::class,'editTalent'])->name('entertainer.talent.edit');
     Route::post('/entertainer/talent/update/{user_id}',[EntertainerController::class,'updateTalent'])->name('entertainer.talent.update');

     Route::get('/entertainer/talent/photo/{entertainer_details_id}',[EntertainerController::class,'showPhoto'])->name('entertainer.photo.show');
     Route::get('/entertainer/talent/photo/delete/{entertainer_details_id}',[EntertainerController::class,'destroyPhoto'])->name('entertainer.talent.photo.delete');
     Route::get('/entertainer/talent/photo/edit/{entertainer_details_id}',[EntertainerController::class,'editPhoto'])->name('entertainer.photo.edit');
     Route::post('/entertainer/talent/photo/update/{entertainer_details_id}',[EntertainerController::class,'updatePhoto'])->name('entertainer.photo.update');

     Route::get('/entertainer/talent/categories/',[EntertainerController::class,'talentCategoriesIndex'])->name('entertainer.talent.categories.index');
     Route::post('/entertainer/talent/category/',[EntertainerController::class,'talentCategoryStore'])->name('entertainer.talent.category.store');
     Route::get('/entertainer/talent/category/edit/{category_id}',[EntertainerController::class,'talentCategoryEditIndex'])->name('entertainer.talent.category.edit.index');
     Route::post('/entertainer/talent/category/update/{category_id}',[EntertainerController::class,'updateTalentCategory'])->name('entertainer.talent.category.update');
     Route::delete('/entertainer/talent/category/delete/{category_id}',[EntertainerController::class,'destroyTalentCategory'])->name('entertainer.talent.category.delete');


    Route::get('/entertainer/talent/price-packages/{entertainer_details_id}',[EntertainerController::class,'pricePackagesIndex'])->name('entertainer.talent.price_packages.index');
    Route::get('/entertainer/talent/price-packages/add/{entertainer_details_id}', [EntertainerController::class, 'createPricePackageIndex'])->name('entertainer.talent.price_packages.add');
    Route::post('/entertainer/talent/price-packages/store/{entertainer_details_id}', [EntertainerController::class, 'storePricePackage'])->name('entertainer.talent.price_packages.store');
    Route::get('/entertainer/talent/price-packages/edit/{price_package_id}', [EntertainerController::class, 'editPricePackageIndex'])->name('entertainer.talent.price_packages.edit');
    Route::post('/entertainer/talent/price-packages/update/{price_package_id}', [EntertainerController::class, 'updatePricePackage'])->name('entertainer.talent.price_packages.update');
    Route::delete('/entertainer/talent/price-packages/delete/{price_package_id}', [EntertainerController::class, 'destroyPricePackage'])->name('entertainer.talent.price_packages.delete');



     //Venue
     Route::resource('venue', VenueController::class)->parameters([
        'venue' => 'user_id'
    ]);;
     Route::get('/venue-providers/venue/add/{user_id}',[VenueController::class,'createVenueIndex'])->name('venue-providers.venue.add');
     Route::post('/venue-providers/venue/store/{user_id}',[VenueController::class,'storeVenue'])->name('venue-providers.venue.store');
     Route::get('/venue-providers/venue/delete/{user_id}',[VenueController::class,'destroyVenue'])->name('venue-providers.venue.delete');
     Route::get('/venue-providers/venue/edit/{user_id}/{venue_id}',[VenueController::class,'editVenue'])->name('venue-providers.venue.edit');
     Route::post('/venue-providers/venue/update/{user_id}',[VenueController::class,'updateVenue'])->name('venue-providers.venue.update');

     Route::get('/venue-providers/venue/categories/',[VenueController::class,'venueCategoriesIndex'])->name('venue-providers.venue.categories.index');
     Route::post('/venue-providers/venue/category/',[VenueController::class,'venueCategoryStore'])->name('venue-providers.venue.category.store');
     Route::get('/venue-providers/venue/category/edit/{category_id}',[VenueController::class,'venueCategoryEditIndex'])->name('venue-providers.venue.category.edit.index');
     Route::post('/venue-providers/venue/category/update/{category_id}',[VenueController::class,'updateVenueCategory'])->name('venue-providers.venue.category.update');
     Route::delete('/venue-providers/venue/category/delete/{category_id}',[VenueController::class,'destroyVenueCategory'])->name('venue-providers.venue.category.delete');

     Route::get('/venue-providers/venue/photo/{venue_id}',[VenueController::class,'showPhoto'])->name('venue-providers.venue.photo.show');
     Route::get('/venue-providers/venue/photo/delete/{venue_id}',[VenueController::class,'destroyPhoto'])->name('venue-providers.venue.photo.delete');
     Route::get('/venue-providers/venue/photo/edit/{venue_id}',[VenueController::class,'editPhoto'])->name('venue-providers.venue.photo.edit');
     Route::post('/venue-providers/venue/photo/update/{venue_id}',[VenueController::class,'updatePhoto'])->name('venue-providers.venue.photo.update');

     Route::get('/venue-providers/venue/venue-pricings/{venue_id}',[VenueController::class,'pricePackagesIndex'])->name('venue-providers.venue.venue_pricings.index');
     Route::get('/venue-providers/venue/venue-pricings/add/{venue_id}',[VenueController::class,'createPricePackageIndex'])->name('venue-providers.venue.venue_pricings.add');

     Route::post('/venue-providers/venue/venue-pricings/store/{venue_id}',[VenueController::class,'storePricePackage'])->name('venue-providers.venue.venue_pricings.store');
     Route::get('/venue-providers/venue/venue-pricings/edit/{venue_pricing_id}',[VenueController::class,'editPricePackageIndex'])->name('venue-providers.venue.venue_pricings.edit');
     Route::post('/venue-providers/venue/venue-pricings/update/{venue_pricing_id}',[VenueController::class,'updatePricePackage'])->name('venue-providers.venue.venue_pricings.update');
     Route::delete('/venue-providers/venue/venue-pricings/delete/{venue_pricing_id}',[VenueController::class,'destroyPricePackage'])->name('venue-providers.venue.venue_pricings.delete');


 //introVideo
     Route::resource('/pages/intro-video', IntrovideoController::class);
      // FeatureAdsPackages
    Route::get('/feature-ads-packages',[FeatureAdsPackagesController::class,'index'])->name('feature_ads_packages.index');
    Route::get('/feature-ads-packages/event/edit/{event_ads_package_id}',[FeatureAdsPackagesController::class,'editEventAdsPackageIndex'])->name('feature_ads_packages.event.edit.index');
    Route::post('/feature-ads-packages/event/update/{event_ads_package_id}',[FeatureAdsPackagesController::class,'updateEventAdsPackage'])->name('feature_ads_packages.event.update');
    Route::get('/feature-ads-packages/talent/edit/{talent_ads_package_id}',[FeatureAdsPackagesController::class,'editTalentAdsPackageIndex'])->name('feature_ads_packages.talent.edit.index');
    Route::post('/feature-ads-packages/talent/update/{talent_ads_package_id}',[FeatureAdsPackagesController::class,'updateTalentAdsPackage'])->name('feature_ads_packages.talent.update');
    Route::get('/feature-ads-packages/venue/edit/{venue_ads_package_id}',[FeatureAdsPackagesController::class,'editVenueAdsPackageIndex'])->name('feature_ads_packages.venue.edit.index');
    Route::post('/feature-ads-packages/venue/update/{venue_ads_package_id}',[FeatureAdsPackagesController::class,'updateVenueAdsPackage'])->name('feature_ads_packages.venue.update');
    // Notification
    Route::get('/notification',[NotificationController::class,'index'])->name('notification.index');
    Route::post('/notification/push',[NotificationController::class,'pushNotification'])->name('notification.push');
    // Chat
    Route::get('/chat',[ChatController::class,'index'])->name('chat.index');





});
/*Team A routes
 * */

