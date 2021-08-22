<?php



Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@login']);

/******* Admin page *******/
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'web'
], function() {

    Route::get('/logout', 'AuthController@logout');

    Route::post('olympiad-test/is_show', 'OlympiadTestController@changeIsShow');
    Route::resource('olympiad-test', 'OlympiadTestController');

    Route::get('answer-olympiad-test', 'AnswerController@showUserOlympiadTest');
    Route::get('answer-olympiad-test/{id}', 'AnswerController@showUserOlympiadTestById');

    Route::post('olympiad-test-question/excel', 'OlympiadTestQuestionController@importExcel');
    Route::post('olympiad-test-question/is_show', 'OlympiadTestQuestionController@changeIsShow');
    Route::resource('olympiad-test-question', 'OlympiadTestQuestionController');

    Route::resource('operation', 'OperationController');
    Route::resource('payment', 'PaymentController');

    Route::post('menu/is_show', 'MenuController@changeIsShow');
    Route::resource('menu', 'MenuController');

    Route::post('banner/is_show', 'BannerController@changeIsShow');
    Route::resource('banner', 'BannerController');

    Route::post('info/is_show', 'InfoController@changeIsShow');
    Route::resource('info', 'InfoController');

    Route::get('client/reset/{id}', 'ClientController@resetPassword');
    Route::post('client/is_show', 'ClientController@changeIsShow');
    Route::resource('client', 'ClientController');

    Route::get('user/reset/{id}', 'UsersController@resetPassword');
    Route::post('user/is_show', 'UsersController@changeIsBan');
    Route::resource('user', 'UsersController');
    Route::any('password', 'UsersController@password');

    Route::get('action', 'IndexController@showAction');
    Route::get('index', 'IndexController@index');

});

/******* Main page *******/
Route::group([
    'middleware' => 'web'
], function() {
    Route::post('image/upload', 'ImageController@uploadImage');
    Route::post('image/upload/file', 'ImageController@uploadFile');
    Route::get('media/{file_name}', 'ImageController@getImage')->where('file_name', '.*');
    Route::get('file/{file_name}', 'ImageController@showFile')->where('file_name','.*');
    Route::any('admin-login', 'Admin\AuthController@login');
});


/******* Index *******/
Route::group([
    'middleware' => 'web',
    'namespace' => 'Index',
], function() {

    Route::get('/', 'IndexController@index');
    Route::get('certificate/{id}', 'CertificateController@getCertificate');

    Route::group([
        'prefix' => 'test'
    ], function() {

        Route::get('{olympiad_test_id}/{user_olympiad_test_id}', 'OlympiadController@showTestById');
        Route::post('pay', 'OlympiadController@payTest');
        Route::post('submit', 'OlympiadController@submitTest');

    });


    Route::get('login', 'AuthController@showLogin');
    Route::post('login', 'AuthController@login');

    Route::group([
        'prefix' => 'auth'
    ], function() {
        Route::get('login', 'AuthController@showLogin')->name('login');
        Route::get('register', 'AuthController@showRegister');
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
    });


    Route::group([
        'prefix' => 'profile'
    ], function() {
        Route::get('/', 'ProfileController@showProfile');
        Route::post('/', 'ProfileController@editProfile');

        Route::get('password', 'ProfileController@showPasswordEdit');
        Route::post('password', 'ProfileController@editPassword');

        Route::get('history', 'ProfileController@showHistory');
        Route::get('test', 'ProfileController@showTestList');
    });

    Route::get('{url}', 'IndexController@showPage');

});

