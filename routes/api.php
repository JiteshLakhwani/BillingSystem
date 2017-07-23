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

Route::post('/login','AuthenticateController@authenticate');

Route::post('/createUser','FirmController@store');

Route::get('/userDetails','UserDetailController@show');

Route::patch('/userDetails/{id}','UserDetailController@update');

Route::get('/login','AuthenticateController@login') -> name('login');


// Routes for states 
Route::get('/getStates','StateController@index');

