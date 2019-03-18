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
Route::group([], function () {
    Route::get('/setting', 'SettingController@index')->name('setting.index');
    Route::get('/install', 'AppsController@installApp')->name('App.install');
    Route::post('/installHandle', 'AppsController@installAppHandle')->name('App.installHandle');
    Route::get('auth', 'AppsController@auth')->name('apps.auth');
});


