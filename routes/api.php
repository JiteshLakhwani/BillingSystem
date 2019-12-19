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



Route::middleware(['authenticate'])->group(function(){
   
    //Route for customer
    Route::apiResource('customers', 'FirmController');

    //API related to bill creation viewing and deletion
    Route::apiResource('bills','BillController');

    // API related to challan
    Route::apiResource('challans', 'ChallanController');

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
    Route::apiResource('userdetails', 'UserDetailController');
    Route::patch('/userDetail/updatePassword','UserDetailController@updatePassword');

    // Routes for states
    Route::apiResource('states', 'StateController');

    //Routes for products
    Route::apiResource('products', 'ProductController');

});

//Testing Route
Route::get('/testing','ReportController@weekSale');
