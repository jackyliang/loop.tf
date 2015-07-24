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

Route::get('UGC', 'UGCController@create');

Route::post('UGC/verify', 'UGCController@verify');

Route::get('schedulizer', 'SchedulizerController@search');
Route::get('autocomplete', 'SchedulizerController@create');

/**
 * Authentication
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
