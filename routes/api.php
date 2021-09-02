<?php

use Illuminate\Http\Request;

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

Route::post('login','Api\AuthController@postLogin');
Route::post('login-with-google','Api\AuthController@loginWithGoogle');
Route::post('registration','Api\AuthController@postRegistration');
Route::post('send-reset-password-code','Api\AuthController@sendToken');
Route::post('reset-password','Api\AuthController@resetPassword');

Route::group(['middleware' =>['auth:api','api.lang'],'namespace'=>'Api'],function (){

    //Profile
    Route::get('profile', 'ProfileController@profile');
    Route::post('update-profile', 'ProfileController@profileUpdate');
    Route::post('change-password', 'ProfileController@changePassword');
    Route::get('user-setting', 'ProfileController@userSetting');
    Route::post('save-user-setting', 'ProfileController@saveUserSetting');

    //Category
    Route::get('category', 'QuestionController@questionCategory');
    Route::get('sub-category/{id}', 'QuestionController@questionSubCategory');
    Route::get('category/{type?}/{id}', 'QuestionController@singleCategoryQuestion');
    Route::post('category-unlock', 'CategoryController@categoryUnlock');

    //Question
//    Route::get('question/{id}', 'QuestionController@singleQuestion');
    Route::post('submit-answer/{id}', 'QuestionController@submitAnswer');

    //Leader Board
    Route::get('leader-board/{type?}', 'QuestionController@leaderBoard');

    // set device id
    Route::get('set-user-device-id/{user_id}/{device_id}','AuthController@setDeviceId');

    //deduct coin
    Route::post('deduct-coin', 'CoinController@deductCoin');
    //add coin
    Route::post('earn-coin', 'CoinController@earnCoin');

    //available coin
    Route::get('coin-setting', 'CoinController@coinSetting');
    Route::get('available-coin', 'CoinController@availabeCoin');
    Route::get('payment-methods', 'CoinController@paymentMethod');
    Route::post('buy-coin', 'CoinController@buyCoin');
    Route::get('buy-coin-history', 'CoinController@buyCoinHistory');

});
