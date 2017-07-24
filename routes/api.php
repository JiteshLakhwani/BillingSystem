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
//Routes for user login
Route::post('/login','AuthenticateController@authenticate');
Route::get('/login','AuthenticateController@login') -> name('login');

//Route for customer
Route::post('/createCustomer','FirmController@store');
Route::patch('/updateCustomer/{id}','FirmController@update');
Route::delete('/deleteCustomer/{id}','FirmController@destroy');
Route::get('/getCustomer','FirmController@index');


Route::get('/testing','FirmController@testing');

//Routes for users OR admin related details 
Route::get('/userDetails','UserDetailController@show');
Route::patch('/userDetails/{id}','UserDetailController@update');
Route::delete('/userDetails/{id}','UserDetailController@destroy');


// Routes for states 
Route::get('/getStates','StateController@index');
Route::post('/addState','StateController@store');
Route::patch('/updateState/{state_code}','StateController@update');
Route::delete('/deleteState/{state_code}', 'StateController@destroy');


//Routes for products
Route::get('/getProducts','ProductController@index');
Route::post('/addProduct','ProductController@store');
Route::patch('/updateProduct/{id}','ProductController@update');
Route::delete('/deleteProduct/{id}', 'ProductController@destroy');



