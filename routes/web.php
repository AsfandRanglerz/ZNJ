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
Route::get('Privacy-policy',[SecurityController::class,'PrivacyPolicy']);

/*Admin routes
 * */

Route::get('/admin',[AuthController::class,'getLoginPage']);
Route::post('/login',[AuthController::class,'Login']);
Route::get('/admin-forgot-password',[AdminController::class,'forgetPassword']);
Route::post('/admin-reset-password-link',[AdminController::class,'adminResetPasswordLink']);
Route::get('/change_password/{id}',[AdminController::class,'change_password']);
Route::post('/admin-reset-password',[AdminController::class,'ResetPassword']);

Route::prefix('admin')->middleware('admin')->group(function (){
    Route::get('dashboard',[AdminController::class,'getdashboard']);
    Route::get('profile',[AdminController::class,'getProfile']);
    Route::post('update-profile',[AdminController::class,'update_profile']);
    Route::post('update-password', [AdminController::class, 'profile_change_password'])->name('profile.change-password');
    Route::get('privacy-policy-edit',[SecurityController::class,'PrivacyPolicyEdit']);
    Route::post('privacy-policy-update',[SecurityController::class,'PrivacyPolicyUpdate']);
    Route::get('term-condition',[SecurityController::class,'TermCondition']);
    Route::get('term-condition-edit',[SecurityController::class,'TermConditionEdit']);
    Route::post('term-condition-update',[SecurityController::class,'TermConditionUpdate']);
    Route::get('logout',[AdminController::class,'logout']);
// Users
    Route::get('/users/index',[UserController::class,'index'])->name('admin.user.index');
//Recruiter
     Route::resource('recruiter', RecruiterController::class);
//Entertainer
     Route::resource('entertainer', EntertainerController::class);
     Route::get('/entertainer/talent/add/{id}',[EntertainerController::class,'createTalentIndex'])->name('entertainer.talent.add');
     Route::post('/entertainer/talent/store/{id}',[EntertainerController::class,'storeTalent'])->name('entertainer.talent.store');
//Venue
     Route::resource('venue', VenueController::class);
     Route::get('/venue-providers/venue/add/{id}',[VenueController::class,'createVenueIndex'])->name('venue-providers.venue.add');
     Route::post('/venue-providers/venue/store/{id}',[VenueController::class,'storeVenue'])->name('venue-providers.venue.store');
 //introVideo
     Route::resource('/pages/intro-video', IntrovideoController::class);
    //

});
/*Team A routes
 * */






/*Team B routes
 * */








/*Team Candidate
 * */
