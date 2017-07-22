<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\AdminFirm;

class UserDetailController extends Controller
{
    //     public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function show()
    {
        
 try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                
                return response()->json(['error' => 'Token Not Available'], 400);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'Token Expired'], 500);
        }
                $id= (integer) $user['id'];
                
                $admindetails = AdminFirm::find($id);
                
                 return Response::json(['username'=> $user['name'],
                                        'email' => $user['email'],
                                        'firm name' => $admindetails['name'],
                                        'name' => $admindetails['person_name'],
                                        'gst number' => $admindetails['gst_number'],
                                        'address' => $admindetails['billing_address'],
                                        'city name' => $admindetails['billing_city_name'],
                                        'state name' => $admindetails['billing_state_name'],
                                        'state code' => $admindetails['billing_state_code'],
                                        'pincode' => $admindetails['billing_pincode'],
                                        'mobile number' => $admindetails['billing_mobile_number'],
                                        'landline number' => $admindetails['billing_landline_number'],
                                        'created date' => $admindetails['created_at'],
                                        'updated date' => $admindetails['updated_at'],

        ]);
    }
}