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

Route::get('/', 'HomeController@index')->name('home');

Route::group([
    'prefix' => 'api',
    'namespace' => 'Api'
], function () {
    Route::get('news', 'NewsController@index');

    Route::group([
        'prefix' => 'weather',
        'namespace' => 'Weather'
    ], function () {
        Route::get('current', 'CurrentController@index');
        Route::get('forecast', 'ForecastController@index');
    });

    Route::group([
        'prefix' => 'music',
        'namespace' => 'Music',
    ], function () {
        Route::get('token', 'TokenController@index');
        Route::get('callback', 'CallbackController@index');
        Route::get('playing', 'PlayingController@index');
    });
});