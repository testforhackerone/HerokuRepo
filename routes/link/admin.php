<?php

Route::group(['middleware' => ['auth','admin','lang'], 'namespace'=> 'Admin'], function() {
    Route::get('/', 'DashboardController@adminDashboardView')->name('adminDashboardView');
    Route::get('/search', 'DashboardController@qsSearch')->name('qsSearch');

    //profile setting
    Route::get('/profile','ProfileController@userProfile')->name('userProfile');
    Route::get('/password-change','ProfileController@passwordChange')->name('passwordChange');
    Route::post('/update-profile','ProfileController@updateProfile')->name('updateProfile');
    Route::post('/change-password','ProfileController@changePassword')->name('changePassword');

    //leaderboard
    Route::get('/leader-board', 'DashboardController@leaderBoard')->name('leaderBoard');

    // Setting
    Route::get('general-setting', 'SettingController@generalSetting')->name('generalSetting');
    Route::post('save-setting', 'SettingController@saveSettings')->name('saveSettings');
    Route::post('save-payment-setting', 'SettingController@savePaymentSettings')->name('savePaymentSettings');

    //User Management
    Route::get('user-list', 'UserController@userList')->name('userList');
    Route::get('add-user', 'UserController@addUser')->name('addUser');
    Route::get('user-details/{id}', 'UserController@userDetails')->name('userDetails');
    Route::get('user-make-admin/{id}', 'UserController@userMakeAdmin')->name('userMakeAdmin');
    Route::get('user-make-user/{id}', 'UserController@userMakeUser')->name('userMakeUser');
    Route::get('user-edit/{id}', 'UserController@editUser')->name('editUser');
    Route::get('user-delete/{id}', 'UserController@userDelete')->name('userDelete');
    Route::get('user-active/{id}', 'UserController@userActivate')->name('userActivate');
    Route::post('user-add-process', 'UserController@userAddProcess')->name('userAddProcess');
    Route::post('user-update-process', 'UserController@userUpdateProcess')->name('userUpdateProcess');

    //Question Category
    Route::get('question-category-list', 'CategoryController@qsCategoryList')->name('qsCategoryList');
    Route::get('question-sub-category-list-{id}', 'CategoryController@qsSubCategoryList')->name('qsSubCategoryList');
    Route::get('question-category-create', 'CategoryController@qsCategoryCreate')->name('qsCategoryCreate');
    Route::get('question-sub-category-create/{id}', 'CategoryController@qsSubCategoryCreate')->name('qsSubCategoryCreate');
    Route::post('question-category-save', 'CategoryController@qsCategorySave')->name('qsCategorySave');
    Route::get('question-category-edit/{id}', 'CategoryController@qsCategoryEdit')->name('qsCategoryEdit');
    Route::get('question-category-delete/{id}', 'CategoryController@qsCategoryDelete')->name('qsCategoryDelete');
    Route::get('question-category-activate/{id}', 'CategoryController@qsCategoryActivate')->name('qsCategoryActivate');
    Route::get('question-category-deactivate/{id}', 'CategoryController@qsCategoryDeactivate')->name('qsCategoryDeactivate');

    //Question
    Route::get('question-list', 'QuestionController@questionList')->name('questionList');
    Route::get('category-question-list/{id}', 'QuestionController@categoryQuestionList')->name('categoryQuestionList');
    Route::get('question-create', 'QuestionController@questionCreate')->name('questionCreate');
    Route::post('question-save', 'QuestionController@questionSave')->name('questionSave');
    Route::get('question-edit/{id}', 'QuestionController@questionEdit')->name('questionEdit');
    Route::get('question-delete/{id}', 'QuestionController@questionDelete')->name('questionDelete');
    Route::get('question-activate/{id}', 'QuestionController@questionActivate')->name('questionActivate');
    Route::get('question-deactivate/{id}', 'QuestionController@questionDectivate')->name('questionDectivate');
    Route::get('excel-upload', 'QuestionController@qsExcelUpload')->name('qsExcelUpload');
    Route::post('excel-upload-process', 'QuestionController@qsExcelUploadProcess')->name('qsExcelUploadProcess');

    //payment methods
    Route::get('payment-methods', 'PaymentController@paymentMethods')->name('paymentMethods');
    Route::post('payment-methods-status-change', 'PaymentController@changePaymentMethodStatus')->name('changePaymentMethodStatus');

    // coins
    Route::get('coin-list', 'CoinController@coinList')->name('coinList');
    Route::get('coin-active-{id}', 'CoinController@coinActive')->name('coinActive');
    Route::get('coin-add', 'CoinController@coinAdd')->name('coinAdd');
    Route::get('coin-edit-{id}', 'CoinController@coinEdit')->name('coinEdit');
    Route::post('coin-add-process', 'CoinController@coinAddProcess')->name('coinAddProcess');

    // sales report
    Route::get('sales-report', 'CoinController@saleReport')->name('saleReport');

});