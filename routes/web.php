<?php

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

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

// Main Controller for redirection
Route::get('/', 'MainController@index');
Route::get('/index', 'MainController@index');

// Image
Route::get('/image/{claim_id}/{filename}', 'MainController@image')->name('image');

// Personal
Route::get('/dashboard_personal', 'MainController@dashboardPersonal');

Route::get('/add_new_claim', 'MainController@addNewClaimForm');
Route::post('/add_new_claim', 'MainController@addNewClaim');

Route::post('/rebill_claim', 'MainController@rebillClaim');
Route::post('/discharge_claim', 'MainController@dischargeClaim');

Route::get('/manage_processor', 'MainController@manageProcessorForm');
Route::post('/manage_processor', 'MainController@manageProcessor');

Route::get('/contact_us', 'MainController@contactUsForm');
Route::post('/contact_us', 'MainController@contactUs');

Route::get('/data_analytics_personal', 'MainController@dataAnalyticsPersonal');

// Processor
Route::get('/dashboard_processor', 'MainController@dashboardProcessor');

Route::get('/manage_all_claim', 'MainController@manageAllClaim');
Route::post('/add_specialist', 'MainController@addSpecialist');
Route::post('/delete_specialist', 'MainController@deleteSpecialist');

Route::get('/data_analytics_processor', 'MainController@dataAnalyticsProcessor');

// Personal & Processor
Route::get('/claim_details/{id?}', 'MainController@claimDetailsForm');
Route::get('/manage_claim/{id?}', 'MainController@manageClaimForm');
Route::post('/update_claim/{id?}', 'MainController@updateClaim');

// Admin
Route::get('/dashboard_admin', 'MainController@dashboardAdmin');
Route::get('/manage_claim_admin', 'MainController@manageClaimAdmin');
Route::get('/manage_user_admin', 'MainController@manageUserAdmin');
Route::get('/manage_feedback_admin', 'MainController@manageFeedbackAdmin');

Route::get('/manage_referraldoctor_admin', 'MainController@manageReferralDoctorAdmin');
Route::get('/manage_location_admin', 'MainController@manageLocationAdmin');

// User Controller
Route::get('/login', 'UsersController@loginForm');
Route::post('/login', 'UsersController@login');

Route::get('/register_processor', 'UsersController@registerProcessorForm');
Route::post('/register_processor', 'UsersController@registerProcessor');

Route::get('/register_personal', 'UsersController@registerPersonalForm');
Route::post('/register_personal', 'UsersController@registerPersonal');

Route::get('/register_practice', 'UsersController@registerPracticeForm');
Route::post('/register_practice', 'UsersController@registerPractice');

Route::get('/logout', 'UsersController@logout');

Route::get('/change_password', 'UsersController@changePasswordForm');
Route::post('/change_password', 'UsersController@changePassword');

Route::get('/forgot_password', 'UsersController@forgotPasswordForm');
Route::post('/forgot_password', 'UsersController@forgotPassword');

Route::get('/reset_password/{token}/{email}', 'UsersController@resetPasswordForm')->name('reset_password');
Route::post('/reset_password/{token}/{email}', 'UsersController@resetPassword');

Route::get('/pricing', 'UsersController@pricing');

Route::get('/email', function() {
    return view('email');
});

Route::get('/migrate', function () {
    //Artisan::call('migrate');
    //Artisan::call('config:cache');
    //Artisan::call('config:clear');
    return view('test');
});

Route::get('/camera', function() {
    return view('camera');
});
