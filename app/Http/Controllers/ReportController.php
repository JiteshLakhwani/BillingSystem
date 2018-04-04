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

class ReportController extends Controller
{
    
    public function BetweenDates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "start_date" => 'required',
            "end_date" => 'required'
            ]);
            
            if ($validator->fails()) {
                return response()->json(["message" => $validator->errors()->all()], 400);
            }
            
            $first_date = date('Y-m-d',strtotime($request->start_date));
            $last_date = date('Y-m-d',strtotime($request->end_date));
            $bills = Bill::whereBetween('created_at', [$first_date, $last_date])->get();
            
            if(count($bills) == 0)
            {
                return response()->json(["message" => "Data not found"]);
            }
            
            $return_bill = array();
            foreach ($bills as $bill)
            {
                $length = count($bill->billdetail);
                $return_billdetail = array();
                
                for ($i = 0; $i < $length; $i++) {
                    $return_billdetail[] = array('hsn_code' => $bill->billdetail[$i]->product['hsn_code'],
                    'product_name' => $bill->billdetail[$i]->product['product_name'],
                    'price' => $bill->billdetail[$i]['price'],
                    'discount_percentage' => $bill->billdetail[$i]['discount_percentage'],
                    'discount_amount' => $bill->billdetail[$i]['discount_amount'],
                    'size' => $bill->billdetail[$i]['size']);
                }
                $return_bill[] = array("id" => $bill['id'],
                "user_id" => $bill['user_id'],
                "username" => $bill->user['name'],
                "firm_id" => $bill['firm_id'],
                "firm_name" => $bill->firm['name'],
                "invoice_no" => $bill['invoice_no'],
                "gstNumber" => $bill->firm['gst_number'],
                "taxable_amount" => $bill['taxable_amount'],
                "sgst_percentage" => $bill['sgst_percentage'],
                "sgst_amount" => $bill['sgst_amount'],
                "cgst_percentage" => $bill['cgst_percentage'],
                "cgst_amount" => $bill['cgst_amount'],
                "igst_percentage" => $bill['igst_percentage'],
                "igst_amount" => $bill['igst_amount'],
                "total_payable_amount" => $bill['total_payable_amount'],
                "created_at" => $bill['created_at'],
                "billdetail" => $return_billdetail);
                
            }
            return response()->json($return_bill);
        }
        
        
        public function fiscalYear($year){
            $bills = Bill::where('invoiceYear',$year)->get();
            
            if(count($bills) == 0)
            {
                return response()->json(["message" => "Data not found"]);
            }
            
            $return_bill = array();
            foreach ($bills as $bill)
            {
                $length = count($bill->billdetail);
                $return_billdetail = array();
                
                for ($i = 0; $i < $length; $i++) {
                    $return_billdetail[] = array('hsn_code' => $bill->billdetail[$i]->product['hsn_code'],
                    'product_name' => $bill->billdetail[$i]->product['product_name'],
                    'price' => $bill->billdetail[$i]['price'],
                    'discount_percentage' => $bill->billdetail[$i]['discount_percentage'],
                    'discount_amount' => $bill->billdetail[$i]['discount_amount'],
                    'size' => $bill->billdetail[$i]['size']);
                }
                $return_bill[] = array("id" => $bill['id'],
                "user_id" => $bill['user_id'],
                "username" => $bill->user['name'],
                "firm_id" => $bill['firm_id'],
                "firm_name" => $bill->firm['name'],
                "invoice_no" => $bill['invoice_no'],
                "invoiceYear" => $bill['invoiceYear'],
                "gstNumber" => $bill->firm['gst_number'],
                "taxable_amount" => $bill['taxable_amount'],
                "sgst_percentage" => $bill['sgst_percentage'],
                "sgst_amount" => $bill['sgst_amount'],
                "cgst_percentage" => $bill['cgst_percentage'],
                "cgst_amount" => $bill['cgst_amount'],
                "igst_percentage" => $bill['igst_percentage'],
                "igst_amount" => $bill['igst_amount'],
                "total_payable_amount" => $bill['total_payable_amount'],
                "created_at" => $bill['created_at'],
                "billdetail" => $return_billdetail);
                
            }
            return response()->json($return_bill);
        }
        
        public function firmName($name){
            $firm = Firm::where('name',$name)->get();
            
            if(count($firm) == 0)
            {
                return response()->json(["message" => "firm not found"]);
            }
            $total_bill = count($firm[0]->bill);
            $return_bill = array();
            $return_billdetail = array();
            for($i=0;$i<$total_bill;$i++){
                $total_bill_details = count ($firm[0]->bill[$i]->billdetail);
                for ($j = 0; $j < $total_bill_details; $j++) {
                    $return_billdetail[] = array(
                        'hsn_code' => $firm[0]->bill[$i]->billdetail[$j]->product['hsn_code'],
                        'product_name' => $firm[0]->bill[$i]->billdetail[$j]->product['product_name'],
                        'price' => $firm[0]->bill[$i]->billdetail[$j]['price'],
                        'discount_percentage' =>  number_format($firm[0]->bill[$i]->billdetail[$j]['discount_percentage'],2),
                        'discount_amount' => number_format($firm[0]->bill[$i]->billdetail[$j]['discount_amount']),
                        'size' => $firm[0]->bill[$i]->billdetail[$j]['size'],
                        'quantity' => $firm[0]->bill[$i]->billdetail[$j]['quantity']);
                    }
                    
                    $return_bill[] = array(
                        'invoice_no' => $firm[0]->bill[$i]['invoice_no'],
                        'taxable_amount' => $firm[0]->bill[$i]['taxable_amount'],
                        'sgst_percentage' => $firm[0]->bill[$i]['sgst_percentage'],
                        'sgst_amount' => $firm[0]->bill[$i]['sgst_amount'],
                        'cgst_percentage' => $firm[0]->bill[$i]['cgst_percentage'],
                        'cgst_amount' => $firm[0]->bill[$i]['cgst_amount'],
                        'igst_percentage' => $firm[0]->bill[$i]['igst_percentage'],
                        'igst_amount' => $firm[0]->bill[$i]['igst_amount'],
                        'total_payable_amount' => $firm[0]->bill[$i]['total_payable_amount'],
                        'bill_details' =>  $return_billdetail
                    );
                }
                return response()->json(["user_id" => $firm[0]->bill[0]['user_id'],
                "username" => $firm[0]->bill[0]->user['name'],
                "admin_firm" => $firm[0]->bill[0]->user->adminfirm['name'],
                "admin_gst" => $firm[0]->bill[0]->user->adminfirm['gst_number'],
                "admin_email" => $firm[0]->bill[0]->user->adminfirm['email'],
                "admin_address" => $firm[0]->bill[0]->user->adminfirm['address'],
                "admin_cityname" => $firm[0]->bill[0]->user->adminfirm['cityname'],
                "admin_state" => $firm[0]->bill[0]->user->adminfirm->state['state_name'],
                "admin_state_code" => $firm[0]->bill[0]->user->adminfirm['state_code'],
                "admin_pincode" => $firm[0]->bill[0]->user->adminfirm['pincode'],
                "admin_mobile_number" => $firm[0]->bill[0]->user->adminfirm['mobile_number'],
                "admin_landline_number" => $firm[0]->bill[0]->user->adminfirm['landline_number'],
                "admin_bank_name" => $firm[0]->bill[0] ->user->adminfirm['bank_name'],
                "admin_branch_name" => $firm[0]->bill[0]->user->adminfirm['branch_name'],
                "admin_ifsc_code" => $firm[0]->bill[0]->user->adminfirm['ifsc_code'],
                "admin_account_no" => $firm[0]->bill[0]->user->adminfirm['account_no'],
                
                "firm_id" => $firm[0]['id'],
                "firm_name" => $firm[0]['name'],
                "customer_name" => $firm[0]['person_name'],
                "customer_gst" => $firm[0]['gst_number'],
                "customer_email" => $firm[0]['email'],
                "shipping_address" => $firm[0]['shipping_address'],
                "shipping_city" => $firm[0]['shipping_city'],
                "shipping_state" => $firm[0]->shippingState['state_name'],
                "shipping_state_code" => $firm[0]['shipping_state_code'],
                "shipping_pincode" => $firm[0]['shipping_pincode'],
                "shipping_mobile_number" => $firm[0]['shipping_mobile_number'],
                "shipping_landline_number" => $firm[0]['shipping_landline_number'],
                "shipping_landline_number" => $firm[0]['shipping_landline_number'],
                
                "billing_address" => $firm[0]['billing_address'],
                "billing_city" => $firm[0]['billing_city'],
                "billing_state" => $firm[0]->billingState['state_name'],
                "billing_state_code" => $firm[0]['billing_state_code'],
                "billing_pincode" => $firm[0]['billing_pincode'],
                "billing_mobile_number" => $firm[0]['billing_mobile_number'],
                "billing_landline_number" => $firm[0]['billing_landline_number'],
                "billing_landline_number" => $firm[0]['billing_landline_number'],
                
                "bill" => $return_bill
                ]);
            }
            
            public function singleBill($invoice_no, $invoiceYear)
            {          
                $billinvoice = Bill::where('invoice_no',$invoice_no)->where('invoiceYear',$invoiceYear)->get();
                if(count($billinvoice) == 0)
                {
                    return response()->json(["message" => "bill not found"]);
                }
                
                
                $bill = Bill::find($billinvoice[0]['id']);
                $length = count($bill->billdetail);
                
                $return_billdetail = array();
                for ($i = 0; $i < $length; $i++) {
                    $return_billdetail[] = array(
                        'hsn_code' => $bill->billdetail[$i]->product['hsn_code'],
                        'product_name' => $bill->billdetail[$i]->product['product_name'],
                        'price' => $bill->billdetail[$i]['price'],
                        'discount_percentage' =>  number_format($bill->billdetail[$i]['discount_percentage'],2),
                        'discount_amount' => number_format($bill->billdetail[$i]['discount_amount']),
                        'size' => $bill->billdetail[$i]['size'],
                        'quantity' => $bill->billdetail[$i]['quantity']
                        
                    );
                }
                return response()->json(["user_id" => $bill['user_id'],
                "username" => $bill->user['name'],
                "admin_firm" => $bill->user->adminfirm['name'],
                "admin_gst" => $bill->user->adminfirm['gst_number'],
                "admin_email" => $bill ->user->adminfirm['email'],
                "admin_address" => $bill->user->adminfirm['address'],
                "admin_cityname" => $bill->user->adminfirm['cityname'],
                "admin_state" => $bill->user->adminfirm->state['state_name'],
                "admin_state_code" => $bill->user->adminfirm['state_code'],
                "admin_pincode" => $bill->user->adminfirm['pincode'],
                "admin_mobile_number" => $bill ->user->adminfirm['mobile_number'],
                "admin_landline_number" => $bill ->user->adminfirm['landline_number'],
                "admin_bank_name" => $bill ->user->adminfirm['bank_name'],
                "admin_branch_name" => $bill ->user->adminfirm['branch_name'],
                "admin_ifsc_code" => $bill ->user->adminfirm['ifsc_code'],
                "admin_account_no" => $bill ->user->adminfirm['account_no'],
                
                "firm_id" => $bill['firm_id'],
                "firm_name" => $bill->firm['name'],
                "customer_name" => $bill->firm['person_name'],
                "customer_gst" => $bill->firm['gst_number'],
                "customer_email" => $bill->firm['email'],
                "shipping_address" => $bill->firm['shipping_address'],
                "shipping_city" => $bill->firm['shipping_city'],
                "shipping_state" => $bill->firm->shippingState['state_name'],
                "shipping_state_code" => $bill->firm['shipping_state_code'],
                "shipping_pincode" => $bill->firm['shipping_pincode'],
                "shipping_mobile_number" => $bill->firm['shipping_mobile_number'],
                "shipping_landline_number" => $bill->firm['shipping_landline_number'],
                "shipping_landline_number" => $bill->firm['shipping_landline_number'],
                
                "billing_address" => $bill->firm['billing_address'],
                "billing_city" => $bill->firm['billing_city'],
                "billing_state" => $bill->firm->billingState['state_name'],
                "billing_state_code" => $bill->firm['billing_state_code'],
                "billing_pincode" => $bill->firm['billing_pincode'],
                "billing_mobile_number" => $bill->firm['billing_mobile_number'],
                "billing_landline_number" => $bill->firm['billing_landline_number'],
                "billing_landline_number" => $bill->firm['billing_landline_number'],
                
                "id" => $bill['id'],
                "invoice_no" => $bill['invoice_no'],
                "invoiceYear" => $bill['invoiceYear'],
                "taxable_amount" => number_format($bill['taxable_amount']),
                "sgst_percentage" => number_format($bill['sgst_percentage'],2),
                "sgst_amount" => number_format($bill['sgst_amount']),
                "cgst_percentage" =>  number_format($bill['cgst_percentage'],2),
                "cgst_amount" => number_format($bill['cgst_amount']),
                "igst_percentage" =>  number_format($bill['igst_percentage'],2),
                "igst_amount" => number_format($bill['igst_amount']),
                "total_payable_amount" => number_format($bill['total_payable_amount']),
                "created_at" => $bill['created_at'],
                "product_detail" => $return_billdetail
                ]);
            }
            
            public function nextInvoice()
            {
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
                
                return response()->json(['invoiceNumber' => $invoiceNumber,
                'year' => $year]);
            }
            
            public function weekSale()
            {
                $AgoDate=Carbon::now()->subWeek()->format('Y-m-d');  
                
                $NowDate=Carbon::now()->format('Y-m-d');  
                
                $bills = Bill::whereBetween('created_at', [$AgoDate,$NowDate])->groupBy('date')
                ->orderBy('date')
                ->get(array(
                    DB::raw('Date(created_at) as date'),
                    DB::raw('SUM(total_payable_amount) as "sale"')
                ));;
                
                $retun_array = array();
                foreach ($bills as $bill)
                {
                    $retun_array[] = array($bill['date'] => $bill['sale']);
                }
                
                return response()->json(['weeksale' => $retun_array]);
            }
            public function monthSale()
            {
                $AgoDate=Carbon::now()->subMonth()->format('Y-m-d');  
                
                $NowDate=Carbon::now()->format('Y-m-d');  
                
                $bills = Bill::whereBetween('created_at', [$AgoDate,$NowDate])->groupBy('date')
                ->orderBy('date')
                ->get(array(
                    DB::raw('Date(created_at) as date'),
                    DB::raw('SUM(total_payable_amount) as "sale"')
                ));;
                
                $retun_array = array();
                foreach ($bills as $bill)
                {
                    $retun_array[] = array($bill['date'] => $bill['sale']);
                }
                
                return response()->json(['weeksale' => $retun_array]);
            }
            
            public function checkInvoice($invoice, $invoiceYear){
                $count = Bill::where('invoice_no',$invoice)->where('invoiceYear',$invoiceYear)->count();
                if($count == 0){
                    return response()->json(['message' => 'proceed']);
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
        