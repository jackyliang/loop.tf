<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'PagesController@home');

/**
 * Notices
 */
Route::resource('notices', 'NoticesController@create');

Route::get('UGC', 'UGCController@create');

Route::get('UGC/verify', 'UGCController@verify');

Route::get('notices/create/confirm', 'NoticesController@confirm');

Route::post('notices', 'NoticesController@store');

/**
 * Authentication
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
