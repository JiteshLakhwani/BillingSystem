<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\AdminFirm;
use \Validator;
use App\User;
use State;

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
                // dd($admindetails['created_at']->toDateString());
                 return Response::json(['username'=> $user['name'],
                                        'email' => $user['email'],

                                        'firm_name' => $admindetails['name'],
                                        'gst_number' => $admindetails['gst_number'],
                                        'address' => $admindetails['address'],
                                        'cityname' => $admindetails['cityname'],
                                        'state_code' => $admindetails['state_code'],
                                        'pincode' => $admindetails['pincode'],
                                        'mobile_number' => $admindetails['mobile_number'],
                                        'landline_number' => $admindetails['landline_number'],
                                        'created_date' => $admindetails['created_at']->toDateString(),
                                        'updated_date' => $admindetails['updated_at']->toDateString(),

        ]);
    }


 public function update(Request $request, $id)
    {

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                
                return response()->json(['error' => 'Token Not Available'], 400);
            }
        }   catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'Token Expired'], 500);
            }

        $checkUser=User::find($id);
        if($checkUser == null)
        {
            return response()->json(["error"=>"User couldn't find"]);
        }
        $validator = Validator::make($request->all(), [
            "username" => 'required|string',
            "email" => 'required|email|max:255',

            "firm_name" => 'required|string',
            "gst_number" => 'required|min:15|max:15',
            "address" => 'required',
            "city_name" => 'required|string',
            "state_code" => 'required|string',
            "pincode" => 'required|integer',
            "mobile_number" => 'integer',
            "landline_number" => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $updatedUser = User::where("id",$id)->update([
            "name" => $request->username,
            "email" => $request->email 
        ]);

        $adminfirm_id= (integer) $user['adminfirm_id'];

        $firm = AdminFirm::where("id", $adminfirm_id)->update([
            "name" => $request->firm_name,
            "gst_number" => $request->gst_number,
            "address" => $request->address,
            "cityname" => $request->city_name,
            "state_code" => $request->state_code,
            "pincode" => $request->pincode,
            "mobile_number" => $request->mobile_number,
            "landline_number" =>  $request->landline_number,
        ]);
        if($updatedUser==1 && $firm==1)
        {
             $user = User::find($id);
             $id= (integer) $user['adminfirm_id'];
                
                $admindetails = AdminFirm::find($id);
                // dd($admindetails['created_at']->toDateString());
                 return Response::json(['username'=> $user['name'],
                                        'email' => $user['email'],

                                        'firm_name' => $admindetails['name'],
                                        'gst_number' => $admindetails['gst_number'],
                                        'address' => $admindetails['address'],
                                        'cityname' => $admindetails['cityname'],
                                        'state_code' => $admindetails['state_code'],
                                        'pincode' => $admindetails['pincode'],
                                        'mobile_number' => $admindetails['mobile_number'],
                                        'landline_number' => $admindetails['landline_number'],
                                        'created_date' => $admindetails['created_at']->toDateString(),
                                        'updated_date' => $admindetails['updated_at']->toDateString(),

                    ]);
        }
        else{
            return response()->json(["message" => "Failed to update record"]);
        }
    }

        public function destroy($id)
    {
         try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                
                return response()->json(['error' => 'Token Not Available'], 400);
            }
        }   catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'Token Expired'], 500);
            }
            $currentUser=$user['id'];
            if($currentUser == $id)
            {
            return response()->json(["message"=>"cannaot delete logged in user"]);    
            }
        $user = User::find($id);
         if($user == null)
        {
            return response()->json(["error"=>"record already deleted"]);
        }
        User::destroy($id);
        $user=User::find($id);
        if($state==null)
        {
            return response()->json(["message"=>"Record deleted successfully"]);
        }
    }
    
}