<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('auth.login');
});

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('auth.showLoginForm');
    Route::post('/login', 'LoginController@login')->name('auth.login');
    Route::post('/logout', 'LoginController@logout')->name('auth.logout');

    Route::get('/signup', 'RegisterController@showSignupForm')->name('auth.showSignupForm');
    Route::post('/signup', 'RegisterController@signup')->name('auth.signup');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    /**
     * Application Modules
     */
    Route::get('draws/lucky-draw', 'LuckyDrawController@index')->name('draws.lucky-draw');
    Route::post('draws/lucky-draw/start-drawing', 'LuckyDrawController@startDrawing')->name('draws.lucky-draw.start');
    Route::get('draws/lucky-draw/random', 'LuckyDrawController@getRandomPhone')->name('draws.lucky-draw.random');

    Route::resource('draws', 'DrawController');
    Route::post('draws/{draw}/prizes/update-order', 'DrawController@updatePrizeOrder')->name('draws.prizes.update-order');

    Route::post('prizes/update-order', 'PrizeController@updateOrder')->name('prizes.update-order');
    Route::resource('prizes', 'PrizeController');

    Route::post('phones/import', 'PhoneController@import')->name('phones.import');
    Route::resource('phones', 'PhoneController');

    /**
     * Application Setting
     */
    Route::resource('/my-profile', 'ProfileController');
    Route::resource('/settings', 'SettingController');
    Route::resource('/users', 'UserController');
    Route::resource('/roles', 'RoleController');
});

Route::post('/upload-single-image', 'ImageController@uploadSingleImage')->name('image.single.upload');
