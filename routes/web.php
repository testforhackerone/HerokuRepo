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

//Route::get('/', function () {
//    return view('welcome');
//});

//userSignUp
Route::get('/signup','AuthController@userSignUp')->name('userSignUp')->middleware('registration');
Route::post('/save','AuthController@userSave')->name('userSave');

//userLogin
Route::get('/signin','AuthController@userSignIn')->name('login');
Route::post('/postsignin','AuthController@loginProcess')->name('loginProcess');
Route::get('verify-{verification_code}','AuthController@verifyEmail')->name('verifyEmail');

//forgot password
Route::get('forget-password','AuthController@forgetPassword')->name('forgetPassword');
Route::post('forget-password-process', 'AuthController@forgetPasswordProcess')->name('forgetPasswordProcess');
Route::get('forget-password-change/{reset_code}', 'AuthController@forgetPasswordChange')->name('forgetPasswordChange');
Route::get('forget-password-reset', 'AuthController@forgetPasswordReset')->name('forgetPasswordReset');
Route::post('forget-password-reset-process/{reset_code}', 'AuthController@forgetPasswordResetProcess')->name('forgetPasswordResetProcess');
Route::get('privacy-and-policy', 'AuthController@privacyPolicy')->name('privacyPolicy');
Route::get('terms-and-conditions', 'AuthController@termsCondition')->name('termsCondition');

require base_path('routes/link/admin.php');

Route::group(['middleware' =>['auth']], function () {
    //logout
    Route::get('/logout', 'AuthController@logout')->name('logOut');
});