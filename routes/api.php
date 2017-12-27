<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'api\LoginController@login');
Route::group(['middleware'=>'checkToken', 'namespace'=>'api'],function(){
	//Authentication Routes
	Route::post('logout','LoginController@logout');

	//User Routes
	Route::post('user/new','UserController@store');//Only admin can add new users.
	Route::post('user/getprofile', 'UserController@getProfile');
	//Rake Routes
	Route::post('rakes/new', 'RakeController@store');
	Route::post('rakes/getall', 'RakeController@getAll');
	Route::post('rakes/{id}', 'RakeController@getByNumber' );
	Route::post('rakes/{id}/coaches','RakeController@getAllCoaches');

	//Coach Routes
	Route::post('coaches/new', 'CoachController@store');
	Route::post('coaches/getall', 'CoachController@getAll');
	Route::post('coaches/{id}', 'CoachController@getByNumber' );
	Route::post('coaches/{id}/status', 'CoachController@getStatus');
	Route::post('coaches/{id}/position', 'CoachController@getPosition');
	//Coach Status Routes
	Route::post('status/new', 'StatusController@store');
	Route::post('status/getall', 'StatusController@getAll');
	//Coach Position Routes
	Route::post('position/new', 'PositionController@store');
	Route::post('position/getall', 'PositionController@getAll');

});

