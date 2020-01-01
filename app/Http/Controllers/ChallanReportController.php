<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\Challan;
use App\Firm;
use \Validator;
use Carbon\Carbon;
use \DB;

class ChallanReportController extends Controller
{
    public function nextChallan()
            {
                date_default_timezone_set('Asia/Kolkata');
                if(date("m") <= "03"){
                    $fullCurrentYear = date("Y"); //2018
                   // $currentYear = date("y"); //18
                    $previousYear = $fullCurrentYear - 1; //2017
                    $year = $previousYear."-".$fullCurrentYear; //2017-18
                    
                }
                
                else{
                    
                    $fullCurrentYear = date("Y"); 
                    //$currentYear = date("y");
                    $nextYear = $fullCurrentYear + 1;
                    $year = $fullCurrentYear."-".$nextYear;
                    
                }
                $count = Challan::get()->where('challanYear','=',$year)->count();
                if($count == 0){
                    $challanNumber = 1;
                    return response()->json(['challanNumber' => $challanNumber,
                    'year' => $year]);
                }
                
                $challan = Challan::where('challanYear',$year)->get();
                $challanNumber = 1;
                $flag = false ; 
                while(!$flag){
                    
                    for ($i=0; $i < $count; $i++) { 
                        if ( $challan[$i]['challan_no'] == $challanNumber ){
                            $flag = false;
                            $challanNumber++;
                            continue;
                        }
                        else{
                            $flag = true;
                        }
                    }
                }
                return response()->json(['challanNumber' => $challanNumber,
                'year' => $year]);   
            }

            public function checkChallan($challan, $challanYear){
                $count = Challan::where('challan_no',$challan)->where('challanYear',$challanYear)->count();
                if($count == 0){
                    return response()->json(['message' => 'proceed']);
                }
                return response()->json(['message' => 'challan already exists']);
            }


            public function singlechallan($challan_no, $challanYear)
        {          
            $challanNumber = Challan::where('challan_no',$challan_no)->where('challanYear',$challanYear)->get();
            if(count($challanNumber) == 0)
            {
                return response()->json(["message" => "challan not found"]);
            }

            
            $challan = challan::find($challanNumber[0]['id']);
            $length = count($challan->challandetail);
            
            $return_challandetail = array();
            for ($i = 0; $i < $length; $i++) {
                $return_challandetail[] = array(
                    'hsn_code' => $challan->challandetail[$i]->product['hsn_code'],
                    'product_name' => $challan->challandetail[$i]->product['product_name'],
                    'price' => $challan->challandetail[$i]['price'],
                    'discount_percentage' =>  number_format($challan->challandetail[$i]['discount_percentage'],2),
                    'discount_amount' => number_format($challan->challandetail[$i]['discount_amount']),
                    'size' => $challan->challandetail[$i]['size'],
                    'quantity' => $challan->challandetail[$i]['quantity']
                    
                );
            }
            return response()->json(["user_id" => $challan['user_id'],
            "username" => $challan->user['name'],
            "admin_firm" => $challan->user->adminfirm['name'],
            "admin_gst" => $challan->user->adminfirm['gst_number'],
            "admin_email" => $challan ->user->adminfirm['email'],
            "admin_address" => $challan->user->adminfirm['address'],
            "admin_cityname" => $challan->user->adminfirm['cityname'],
            "admin_state" => $challan->user->adminfirm->state['state_name'],
            "admin_state_code" => $challan->user->adminfirm['state_code'],
            "admin_pincode" => $challan->user->adminfirm['pincode'],
            "admin_mobile_number" => $challan ->user->adminfirm['mobile_number'],
            "admin_landline_number" => $challan ->user->adminfirm['landline_number'],
            
            "firm_id" => $challan['firm_id'],
            "firm_name" => $challan->firm['name'],
            "customer_name" => $challan->firm['person_name'],
            "customer_gst" => $challan->firm['gst_number'],
            "customer_email" => $challan->firm['email'],
            "shipping_address" => $challan->firm['shipping_address'],
            "shipping_city" => $challan->firm['shipping_city'],
            "shipping_state" => $challan->firm->shippingState['state_name'],
            "shipping_state_code" => $challan->firm['shipping_state_code'],
            "shipping_pincode" => $challan->firm['shipping_pincode'],
            "shipping_mobile_number" => $challan->firm['shipping_mobile_number'],
            "shipping_landline_number" => $challan->firm['shipping_landline_number'],
            "shipping_landline_number" => $challan->firm['shipping_landline_number'],
            
            "billing_address" => $challan->firm['billing_address'],
            "billing_city" => $challan->firm['billing_city'],
            "billing_state" => $challan->firm->billingState['state_name'],
            "billing_state_code" => $challan->firm['billing_state_code'],
            "billing_pincode" => $challan->firm['billing_pincode'],
            "billing_mobile_number" => $challan->firm['billing_mobile_number'],
            "billing_landline_number" => $challan->firm['billing_landline_number'],
            "billing_landline_number" => $challan->firm['billing_landline_number'],
            
            "id" => $challan['id'],
            "challan_no" => $challan['challan_no'],
            "challanYear" => $challan['challanYear'],
            "total_payable_amount" => number_format($challan['total_payable_amount']),
            "created_at" => $challan['created_at'],
            "product_detail" => $return_challandetail
            ]);
        }

        public function fiscalYear($year){
            $challans = Challan::where('challanYear',$year)->get();
            
            if(count($challans) == 0)
            {
                return response()->json(["message" => "Data not found"]);
            }
            
            $return_challan = array();
            foreach ($challans as $challan)
            {
                $length = count($challan->challandetail);
                $return_challandetail = array();
                
                for ($i = 0; $i < $length; $i++) {
                    $return_challandetail[] = array('hsn_code' => $challan->challandetail[$i]->product['hsn_code'],
                    'product_name' => $challan->challandetail[$i]->product['product_name'],
                    'price' => $challan->challandetail[$i]['price'],
                    'discount_percentage' => $challan->challandetail[$i]['discount_percentage'],
                    'discount_amount' => $challan->challandetail[$i]['discount_amount'],
                    'size' => $challan->challandetail[$i]['size']);
                }
                $return_challan[] = array("id" => $challan['id'],
                "user_id" => $challan['user_id'],
                "username" => $challan->user['name'],
                "firm_id" => $challan['firm_id'],
                "firm_name" => $challan->firm['name'],
                "challan_no" => $challan['challan_no'],
                "challanYear" => $challan['challanYear'],
                "total_payable_amount" => $challan['total_payable_amount'],
                "created_at" => $challan['created_at'],
                "challandetail" => $return_challandetail);
                
            }
            return response()->json($return_challan);
        }
}
