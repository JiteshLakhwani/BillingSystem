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
Route::post('/createCustomer','FirmController@store')->middleware('myauth');
Route::patch('/updateCustomer/{id}','FirmController@update')->middleware('myauth');
Route::delete('/deleteCustomer/{id}','FirmController@destroy')->middleware('myauth');
Route::get('/getCustomer','FirmController@index')->middleware('myauth');
Route::get('/showCustomer/{id}','FirmController@show')->middleware('myauth');
//This route is created to show drop down list on frontend 
Route::get('/listCustomer','FirmController@lists')->middleware('myauth');

//API related to bill creation viewing and deletion
Route::get('/getBill','BillController@index')->middleware('myauth');
Route::post('/createBill','BillController@store')->middleware('myauth');
Route::delete('/deleteBill/{id}','BillController@destroy')->middleware('myauth');

//API relted to reports
Route::post('/betweenDate', 'ReportController@BetweenDates')->middleware('myauth');
Route::get('/getBill/{invoice}','ReportController@singleBill')->middleware('myauth');
Route::get('/invoiceNumber','ReportController@nextInvoice')->middleware('myauth');
Route::get('/weekSale','ReportController@weekSale')->middleware('myauth');

//Routes for admin related details
Route::get('/userDetails','UserDetailController@show')->middleware('myauth');
Route::patch('/userDetails/{id}','UserDetailController@update')->middleware('myauth');
Route::delete('/userDetails/{id}','UserDetailController@destroy')->middleware('myauth');
Route::post('/userDetails/create','UserDetailController@create')->middleware('myauth');
Route::patch('/userDetail/updatePassword','UserDetailController@updatePassword')->middleware('myauth');

// Routes for states
Route::get('/getStates','StateController@index')->middleware('myauth');
Route::post('/addState','StateController@store')->middleware('myauth');
Route::patch('/updateState/{state_code}','StateController@update')->middleware('myauth');
Route::delete('/deleteState/{state_code}', 'StateController@destroy')->middleware('myauth');


//Routes for products
Route::get('/getProducts','ProductController@index')->middleware('myauth');
Route::post('/addProduct','ProductController@store')->middleware('myauth');
Route::patch('/updateProduct/{id}','ProductController@update')->middleware('myauth');
Route::delete('/deleteProduct/{id}', 'ProductController@destroy')->middleware('myauth');

//Testing Route
Route::get('/testing','ReportController@weekSale');
