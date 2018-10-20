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
Route::get('/token', 'AuthenticateController@token');



Route::middleware(['myauth'])->group(function(){
   
    //Route for customer
    Route::get('/getCustomer','FirmController@index');
    Route::get('/showCustomer/{id}','FirmController@show');
    Route::post('/createCustomer','FirmController@store');
    Route::patch('/updateCustomer/{id}','FirmController@update');
    Route::delete('/deleteCustomer/{id}','FirmController@destroy');

    //This route is created to show drop down list on frontend 
    Route::get('/listCustomer','FirmController@lists');

    //API related to bill creation viewing and deletion
    Route::get('/getBills','BillController@index');
    Route::post('/createBill','BillController@store');
    Route::delete('/deleteBill/{id}','BillController@destroy');

    // API related to challan
    Route::post('/createChallan','ChallanController@store');
    Route::delete('/deleteChallan/{id}','ChallanController@destroy');
    Route::get('/getChallans','ChallanController@index');

    // API related to reports challan
    Route::get('/getChallan/{challan_no}/{challanYear}','ChallanReportController@singleChallan');
    Route::get('/getChallans/{year}','ChallanReportController@fiscalYear');
    Route::get('/challanNumber','ChallanReportController@nextChallan');
    Route::get('/checkChallan/{challan}/{challanYear}','ChallanReportController@checkChallan');

    //API relted to reports BILLS
    Route::post('/betweenDate', 'ReportController@BetweenDates');
    Route::get('/getBill/{invoice_no}/{invoiceYear}','ReportController@singleBill');
    Route::get('/getBills/{year}','ReportController@fiscalYear');
    Route::get('/invoiceNumber','ReportController@nextInvoice');
    Route::get('/weekSale','ReportController@weekSale');
    Route::get('/firmName/{name}','ReportController@firmName');
    Route::get('/checkInvoice/{invoice}/{invoiceYear}','ReportController@checkInvoice');

    Route::get('/years','ReportController@allUniqueYears');

    //Routes for admin related details
    Route::get('/userDetails','UserDetailController@show');
    Route::patch('/userDetails/{id}','UserDetailController@update');
    Route::delete('/userDetails/{id}','UserDetailController@destroy');
    Route::post('/userDetails/create','UserDetailController@create');
    Route::patch('/userDetail/updatePassword','UserDetailController@updatePassword');

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

});



//Testing Route
Route::get('/testing','ReportController@weekSale');
