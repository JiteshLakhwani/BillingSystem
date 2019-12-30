<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\Bill;
use App\Firm;
use \Validator;
use Carbon\Carbon;
use \DB;
use App\Challan;
use App\Repositories\Services\ReportService;
use App\Http\CommonValidator\RequestValidator;

class ReportController extends Controller
{
    protected $reportService;

    protected $requestValidator;

    public function __construct (ReportService $reportService, RequestValidator $requestValidator){

        $this->reportService = $reportService;

        $this->requestValidator = $requestValidator;
    }
    
    public function BetweenDates(Request $request){
        
        $validate = $this->requestValidator->validateRequest($request, [
            "start_date" => 'required',
            "end_date" => 'required'
        ]);

        if($validate == "validatePass"){
            
            return  $this->reportService->reportBetweenTwoDates($request);
        }

        return $validate;
    }

    public function fiscalYear($year){
                    
        return  $this->reportService->reportFiscalYear($year);
    }

    public function firmName($name){
        
        return $this->reportService->reportByFirmName($name);
    }

    public function singleBill($invoice_no, $invoiceYear) {

        return $this->reportService->reportByInvoiceNumber($invoice_no, $invoiceYear);    
    }

    public function nextInvoice() {
        
        date_default_timezone_set('Asia/Kolkata');
        if(date("m") <= "03"){
            $fullCurrentYear = date("Y"); //2018
            $currentYear = date("y"); //18
            $previousYear = $fullCurrentYear - 1; //2017
            $year = $previousYear."-".$currentYear; //2017-18
                    
        }
                
        else{
                    
            $fullCurrentYear = date("Y"); 
            $currentYear = date("y");
            $nextYear = $currentYear + 1;
            $year = $fullCurrentYear."-".$nextYear;
                    
        }
        $count = Bill::get()->where('invoiceYear','=',$year)->count();
            
        if($count == 0){
            $invoiceNumber = 1;
            return response()->json(['invoiceNumber' => $invoiceNumber,
            'year' => $year]);
        }
                
        $bill = Bill::where('invoiceYear',$year)->get();
        $invoiceNumber = 1;
        $flag = false ; 
        while(!$flag){
            
            for ($i=0; $i < $count; $i++) { 
            
                if ( $bill[$i]['invoice_no'] == $invoiceNumber ){
                  
                    $flag = false;
                    $invoiceNumber++;
                    continue;
                }
                else{
                    $flag = true;
                }
            }
        }
                
        return response()->json(['invoiceNumber' => $invoiceNumber,'year' => $year]);
    }
            
    public function weekSale() {
                
        $AgoDate=Carbon::now()->subWeek()->format('Y-m-d');  
                
        $NowDate=Carbon::now()->format('Y-m-d');  
                
        $bills = Bill::whereBetween('created_at', [$AgoDate,$NowDate])->groupBy('date')
        ->orderBy('date')
        ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(total_payable_amount) as "sale"')
           ));
                
        $retun_array = array();
        foreach ($bills as $bill) {
            $retun_array[] = array($bill['date'] => $bill['sale']);
        }
                
        return response()->json(['weeksale' => $retun_array]);
    }
        
    public function monthSale() {
         
        $AgoDate=Carbon::now()->subMonth()->format('Y-m-d');  
        $NowDate=Carbon::now()->format('Y-m-d');  
        $bills = Bill::whereBetween('created_at', [$AgoDate,$NowDate])->groupBy('date')
        ->orderBy('date')
        ->get(array(
            DB::raw('Date(created_at) as date'),
            DB::raw('SUM(total_payable_amount) as "sale"')
        ));;
                
        
        $retun_array = array();
        
        foreach ($bills as $bill) {
                    
            $retun_array[] = array($bill['date'] => $bill['sale']);
        }

        return response()->json(['weeksale' => $retun_array]);
    }
            
    public function checkInvoice($invoice, $invoiceYear){
    
        $count = Bill::where('invoice_no',$invoice)->where('invoiceYear',$invoiceYear)->count();
        if($count == 0){
    
            return response()->json(['message' => 'Invoice number doen\'t exists']);
        }
        return response()->json(['message' => 'invoice already exists']);
    }
            
    public function allUniqueYears(){
    
        $allInvoiceYear = Bill::select('invoiceYear')->distinct()->get();
        $allChallanYear = challan::select('challanYear')->distinct()->get();
        $arrayChallan = array();
        $arrayInvoice = array();
    
        foreach ($allInvoiceYear as $invoiceYear) {
    
            $arrayInvoice = $invoiceYear['invoiceYear'];
        }
        foreach ($allChallanYear as $challanYear) {
    
            $arrayChallan = $challanYear['challanYear'];
        }
        return response()->json(array_merge($challanYear,$arrayInvoice));    
    }
    
}
        