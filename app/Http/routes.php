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
| - index: Transaction initiation / checkout page
| - ext  : Sending the transaction to Yippster test service
|
*/
Route::get('/yippster-index', [
	'uses' => 'YippsterController@index',
	'as'   => 'yippster.index'
]);

Route::post('yippster-test', [
	'uses' => 'YippsterController@testYippsterRequest'
]);

Route::get('/yippster-ext', [
	'uses' => 'YippsterController@ext',
	'as'   => 'yippster.ext'
]);

/*
|--------------------------------------------------------------------------
| Yippster mock service
|--------------------------------------------------------------------------
| - Local send transaction information to mock service
| - mock service send back transaction status in fallowing 3 situations.
|   1. success
| 	2. fail
|	3. cancel
*/

/**
 * Route to send successful message. 
 *
 * - Redirect back to "http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request"
 * [
 *   'c'      => payment
 *	 'a'      => yippster_payment_request_result
 *   'v'      => 'ajax'
 *   'result' => 'SUCCESS'
 * ]
 *
 * - Send message back to migbo callback "http://60.251.3.181:55555/yippster/notify"
 */
Route::post('/yippster-mock/successful', [
	'uses' => 'YippsterMockServicesController@success',
	'as'   => 'Yippster.success'
]);

Route::post('/yippster-mock/fail', [
	'uses' => 'YippsterMockServicesController@fail',
	'as'   => 'Yippster.fail'
]);

Route::post('/yippster-mock/cancel', [
	'uses' => 'YippsterMockServicesController@cancel',
	'as'   => 'Yippster.cancel'
]);


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
