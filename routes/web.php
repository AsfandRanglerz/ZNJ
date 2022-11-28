<?php

use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\TeamAController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RecruiterController;
use App\Http\Controllers\Admin\EntertainerController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\IntrovideoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TalentController;

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
// <<<<<<< Updated upstream
    Route::get('privacy-policy-edit',[SecurityController::class,'PrivacyPolicyEdit']);
    Route::post('privacy-policy-update',[SecurityController::class,'PrivacyPolicyUpdate']);
    Route::get('term-condition',[SecurityController::class,'TermCondition']);
    Route::get('term-condition-edit',[SecurityController::class,'TermConditionEdit']);
    Route::post('term-condition-update',[SecurityController::class,'TermConditionUpdate']);
    Route::get('logout',[AdminController::class,'logout']);
// Users
    Route::get('/users/index',[UserController::class,'index'])->name('admin.user.index');
//Recruiter
         // Recruiter
    Route::resource('recruiter', RecruiterController::class)->parameters([
        'recruiter' => 'user_id'
    ]);
    Route::get('/recruiter/event/edit/event-id-{event_id}', [RecruiterController::class, 'editEventIndex'])->name('recruiter.event.edit.index');
    Route::post('/recruiter/event/update/event-id-{event_id}', [RecruiterController::class, 'updateEvent'])->name('recruiter.event.update');
    Route::get('/recruiter/event/add/user-id-{event_id}', [RecruiterController::class, 'createEventIndex'])->name('recruiter.event.add.index');
    Route::post('/recruiter/event/add/user-id-{user_id}',[RecruiterController::class, 'storeEvent'])->name('recruiter.event.store');
    Route::get('/recruiter/event/entertainers/event-id-{event_id}',[RecruiterController::class, 'eventEntertainersIndex'])->name('recruiter.event_entertainers.index');
    Route::get('/recruiter/event/venues/event-id-{event_id}',[RecruiterController::class, 'eventVenuesIndex'])->name('recruiter.event_venues.index');
//Entertainer
     Route::resource('entertainer', EntertainerController::class);
     Route::get('/entertainer/talent/add/{id}',[EntertainerController::class,'createTalentIndex'])->name('entertainer.talent.add');
     Route::post('/entertainer/talent/store/{id}',[EntertainerController::class,'storeTalent'])->name('entertainer.talent.store');
     Route::get('/entertainer/talent/delete/{id}',[EntertainerController::class,'destroyTalent'])->name('entertainer.talent.delete');
     Route::get('/entertainer/talent/edit/{id}',[EntertainerController::class,'editTalent'])->name('entertainer.talent.edit');
     Route::post('/entertainer/talent/update/{id}',[EntertainerController::class,'updateTalent'])->name('entertainer.talent.update');
     Route::get('/entertainer/talent/photo/{id}',[EntertainerController::class,'showPhoto'])->name('entertainer.photo.show');
     Route::get('/entertainer/talent/photo/delete/{id}',[EntertainerController::class,'destroyPhoto'])->name('entertainer.talent.photo.delete');
     Route::get('/entertainer/talent/photo/edit/{id}',[EntertainerController::class,'editPhoto'])->name('entertainer.photo.edit');
     Route::post('/entertainer/talent/photo/update/{id}',[EntertainerController::class,'updatePhoto'])->name('entertainer.photo.update');
     Route::get('/entertainer/talent/categories/',[EntertainerController::class,'talentCategoriesIndex'])->name('entertainer.talent.categories.index');
     Route::post('/entertainer/talent/category/',[EntertainerController::class,'talentCategoryStore'])->name('entertainer.talent.category.store');
     Route::get('/entertainer/talent/category/edit/{category_id}',[EntertainerController::class,'talentCategoryEditIndex'])->name('entertainer.talent.category.edit.index');
     Route::post('/entertainer/talent/category/update/{category_id}',[EntertainerController::class,'updateTalentCategory'])->name('entertainer.talent.category.update');
     Route::delete('/entertainer/talent/category/delete/{category_id}',[EntertainerController::class,'destroyTalentCategory'])->name('entertainer.talent.category.delete');


     //Venue
     Route::resource('venue', VenueController::class);
     Route::get('/venue-providers/venue/add/{id}',[VenueController::class,'createVenueIndex'])->name('venue-providers.venue.add');
     Route::post('/venue-providers/venue/store/{id}',[VenueController::class,'storeVenue'])->name('venue-providers.venue.store');
     Route::get('/venue-providers/venue/delete/{id}',[VenueController::class,'destroyVenue'])->name('venue-providers.venue.delete');
     Route::get('/venue-providers/venue/edit/{id}',[VenueController::class,'editVenue'])->name('venue-providers.venue.edit');
     Route::post('/venue-providers/venue/update/{id}',[VenueController::class,'updateVenue'])->name('venue-providers.venue.update');

     Route::get('/venue-providers/venue/categories/',[VenueController::class,'venueCategoriesIndex'])->name('venue-providers.venue.categories.index');
     Route::post('/venue-providers/venue/category/',[VenueController::class,'venueCategoryStore'])->name('venue-providers.venue.category.store');
     Route::get('/venue-providers/venue/category/edit/{category_id}',[VenueController::class,'venueCategoryEditIndex'])->name('venue-providers.venue.category.edit.index');
     Route::post('/venue-providers/venue/category/update/{category_id}',[VenueController::class,'updateVenueCategory'])->name('venue-providers.venue.category.update');
     Route::delete('/venue-providers/venue/category/delete/{category_id}',[VenueController::class,'destroyVenueCategory'])->name('venue-providers.venue.category.delete');

     Route::get('/venue-providers/venue/photo/{id}',[VenueController::class,'showPhoto'])->name('venue-providers.venue.photo.show');
     Route::get('/venue-providers/venue/photo/delete/{id}',[VenueController::class,'destroyPhoto'])->name('venue-providers.venue.photo.delete');
     Route::get('/venue-providers/venue/photo/edit/{id}',[VenueController::class,'editPhoto'])->name('venue-providers.venue.photo.edit');
     Route::post('/venue-providers/venue/photo/update/{id}',[VenueController::class,'updatePhoto'])->name('venue-providers.venue.photo.update');


 //introVideo
     Route::resource('/pages/intro-video', IntrovideoController::class);
 //Talent
     Route::resource('/talent', TalentController::class);


});
/*Team A routes
 * */






/*Team B routes
 * */








/*Team Candidate
 * */
