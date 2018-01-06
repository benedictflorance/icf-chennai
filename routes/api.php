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

	//Admin Routes
	Route::post('admin/newuser','AdminController@store');
	Route::post('admin/edituser', 'AdminController@editProfile');
	Route::post('admin/getall', 'AdminController@getAllProfiles');
	Route::post('admin/getuser', 'AdminController@getProfile');


	//User Controller
	Route::post('user/profile', 'UserController@getProfile');
	Route::post('user/editprofile','UserController@editProfile');

	//Rake Routes
	Route::post('rakes/new', 'RakeController@store');
	Route::post('rakes/edit', 'RakeController@edit');
	Route::post('rakes/delete', 'RakeController@delete');
	Route::post('rakes/getall', 'RakeController@getAll');
	Route::post('rakes/{rake_num}', 'RakeController@getByNumber' );
	Route::post('rakes/{rake_num}/coaches','RakeController@getAllCoaches');
	Route::post('rakes/{rake_num}/statuses','RakeController@getAllStatuses');
	Route::post('rakes/{rake_num}/positions','RakeController@getAllPositions');

	//Coach Routes
	Route::post('coaches/new', 'CoachController@store');
	Route::post('coaches/edit', 'CoachController@edit');
	Route::post('coaches/delete', 'CoachController@delete');
	Route::post('coaches/getall', 'CoachController@getAll');
	Route::post('coaches/{coach_num}', 'CoachController@getByNumber' );
	Route::post('coaches/{coach_num}/status', 'CoachController@getStatus');
	Route::post('coaches/{coach_num}/position', 'CoachController@getPosition');
	//Coach Status Routes
	Route::post('status/new', 'StatusController@store');
	Route::post('status/getall', 'StatusController@getAll');
	//Coach Position Routes
	Route::post('position/new', 'PositionController@store');
	Route::post('position/getall', 'PositionController@getAll');
	Route::post('production/{line_no}/{stage_no}', 'PositionController@getProduction');
	Route::post('commission/{line_no}', 'PostionController@getCommission');
	Route::post('dispatch/{line_no}/{stage_no}', 'PositionController@getDespatch');
	Route::post('paint/{line_no}','PositionController@getPaint');
	Route::post('out/{line_no}', 'PositionController@getOut');
	Route::post('shell', 'PositionController@getShell');
});

