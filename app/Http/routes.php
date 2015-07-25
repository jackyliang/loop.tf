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
 * UGC Roster Check form
 */
Route::get('UGC', 'UGCController@create');

/**
 * UGC Roster Check results
 */
Route::post('UGC/verify', 'UGCController@verify');

/**
 * Schedulizer class search form
 */
Route::get('schedulizer/search', 'SchedulizerController@search');

/**
 * TODO: Schedulizer home page
 */
Route::get('schedulizer', 'SchedulizerController@home');

/**
 * Schedulizer autocomplete API
 */
Route::get('autocomplete', 'SchedulizerController@autocomplete');

/**
 * Schedulizer class search results page
 */
Route::get('schedulizer/result', 'SchedulizerController@result');

/**
 * Authentication
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
