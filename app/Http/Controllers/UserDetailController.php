<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\AdminFirm;
use \Validator;

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
    
                $id= (integer) $user['adminfirm_id'];
                
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


 public function update(Request $request, $id)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                
                return response()->json(['error' => 'Token Not Available'], 400);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'Token Expired'], 500);
        }
        $validator = Validator::make($request->all(), [
            "name" => 'required|string',
            // "email" => 'required|email|max:255|unique:users',
            // "firm name" => 'required|string',
            "gst_number" => 'required|min:15|max:15',
            "address" => 'required',
            "city_name" => 'required|string',
            "state_name" => 'required|string',
            "state_code" => 'required|string',
            "pincode" => 'required|integer',
            "mobile_number" => 'integer',
            "landline_number" => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $user = AdminFirm::where("id", $id)->update([
            "name" => $request->name,
            "gst_number" => $request->gst_number,
            "billing_address" => $request->address,
            "billing_city_name" => $request->city_name,
            "billing_state_name" => $request->state_name,
            "billing_state_code" => $request->state_code,
            "billing_pincode" => $request->pincode,
            "billing_mobile_number" => $request->mobile_number,
            "billing_landline_number" =>  $request->landline_number,
        ]);

        return response()->json(["user" => $user]);

    }

}