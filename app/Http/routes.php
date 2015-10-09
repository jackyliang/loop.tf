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

use Illuminate\Support\Facades\Redirect;

Route::get('/', 'PagesController@home');

/**
 * UGC Roster Check form
 */
Route::get('ugc', 'UGCController@create');

/**
 * UGC Roster Check results
 */
Route::post('ugc/verify', 'UGCController@verify');

/**
 * Redirect old users of loop.tf/schedulizer to the new site
 */
Route::get('schedulizer', function(){
    return Redirect::to('http://schedulizer.me');
});

/**
 * Schedulizer class search results page
 */
Route::get('schedulizer/results', 'SchedulizerController@results');

/**
 * StockTwits Parse Data
 */
Route::get('stocktwits/results', 'StockTwitsController@results');

Route::get('groupthink/search', 'StockTwitsController@search');

/**
 * StockTwits Results Page
 */
Route::get('groupthink', 'StockTwitsController@home');

/**
 * Authentication
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
