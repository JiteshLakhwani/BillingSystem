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
                $count = Challan::get()->where('challanYear','=',$year)->count();
                if($count == 0){
                    $challanNumber = 1;
                    return response()->json(['challanNumber' => $challanNumber,
                    'year' => $year]);
                }
                
                $bill = Bill::where('challanYear',$year)->get();
                $challanNumber = 1;
                $flag = false ; 
                while(!$flag){
                    
                    for ($i=0; $i < $count; $i++) { 
                        if ( $bill[$i]['challan_no'] == $challanNumber ){
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
}
