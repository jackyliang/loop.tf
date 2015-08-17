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
 * Home page of Schedulizer
 */
Route::get('schedulizer', 'SchedulizerController@home');

/**
 * UGC Roster Check form
 */
Route::get('ugc', 'UGCController@create');

/**
 * UGC Roster Check results
 */
Route::post('ugc/verify', 'UGCController@verify');

/**
 * Schedulizer class search form
 */
Route::get('schedulizer/search', 'SchedulizerController@search');

/**
 * Schedulizer generated schedules
 */
Route::get('schedulizer/schedule', 'SchedulizerController@schedule');

/**
 * Add class to session
 */
Route::post('schedulizer/add', 'SchedulizerController@add');

/**
 * Remove class from session
 */
Route::post('schedulizer/remove', 'SchedulizerController@remove');

/**
 * API for classes generated
 */
Route::get('schedulizer/schedules', 'SchedulizerController@generate');

/**
 * Clear the cart
 * TODO: Change this to POST
 */
Route::get('schedulizer/cart/clear', 'SchedulizerController@clear');

/**
 * TODO: Remove this test API
 */
Route::get('schedulizer/classes', 'SchedulizerController@classes');

/**
 * Get cart contents
 */
Route::get('schedulizer/cart', 'SchedulizerController@cart');

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
Route::get('schedulizer/results', 'SchedulizerController@results');

/**
 * Authentication
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
