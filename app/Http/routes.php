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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('/jackpot-it', [
	'as'	=>	'migme.jackpot',
	'uses'	=>	'JackpotController@getJackpot'
]);


/*
|--------------------------------------------------------------------------
| Yippster
|--------------------------------------------------------------------------
| 1. index: Transaction initiation / checkout page
|
|
|
*/
Route::get('/yippster-index', [
	'uses' => 'YippsterController@index',
	'as'   => 'yippster.index'
]);

Route::get('/yippster-ext', [
	'uses' => 'YippsterController@ext',
	'as'   => 'yippster.ext'
]);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
