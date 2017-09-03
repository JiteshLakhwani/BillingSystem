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
    public function show(Request $request)
    {
         $user = $request->route()->parameter('user');
                  return Response::json(['username'=> $user['name'],
                                        'email' => $user->adminfirm['email'],

                                        'firm_name' => $user->adminfirm['name'],
                                        'gst_number' => $user->adminfirm['gst_number'],
                                        'address' => $user->adminfirm['address'],
                                        'cityname' => $user->adminfirm['cityname'],
                                        'state_code' => $user->adminfirm['state_code'],
                                        'pincode' => $user->adminfirm['pincode'],
                                        'mobile_number' => $user->adminfirm['mobile_number'],
                                        'landline_number' => $user->adminfirm['landline_number'],
                                        'created_date' => $user->adminfirm['created_at'],
                                        'updated_date' => $user->adminfirm['updated_at']
                                        

        ]);
    }


 public function update(Request $request, $id)
    {
        $user = $request->route()->parameter('user');
        
        $validator = Validator::make($request->all(), [
            "username" => 'required|string',
            "email" => 'required|email|max:255',

            "name" => 'required|string',
            "gst_number" => 'required|min:15|max:15',
            "address" => 'required',
            "cityname" => 'required|string',
            "state_code" => 'required|integer',
            "pincode" => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $updatedUser = User::where("id",$id)->update([
            "name" => $request->username 
        ]);

        $firm = AdminFirm::where("id", $user->adminfirm['id'])->update([
            "name" => $request->name,
            "email" => $request->email,
            "gst_number" => $request->gst_number,
            "address" => $request->address,
            "cityname" => $request->cityname,
            "state_code" => $request->state_code,
            "pincode" => $request->pincode,
            "mobile_number" => $request->mobile_number,
            "landline_number" =>  $request->landline_number,
        ]);
        if($updatedUser==1 && $firm==1)
        {
                $user=User::find($id);
                return Response::json(['username'=> $user['name'],
                                        'email' => $user->adminfirm['email'],

                                        'firm_name' => $user->adminfirm['name'],
                                        'gst_number' => $user->adminfirm['gst_number'],
                                        'address' => $user->adminfirm['address'],
                                        'cityname' => $user->adminfirm['cityname'],
                                        'state_code' => $user->adminfirm['state_code'],
                                        'pincode' => $user->adminfirm['pincode'],
                                        'mobile_number' => $user->adminfirm['mobile_number'],
                                        'landline_number' => $user->adminfirm['landline_number'],
                                        'created_date' => $user->adminfirm['created_at'],
                                        'updated_date' => $user->adminfirm['updated_at']

                    ]);
        }
        else{
            return response()->json(["message" => "Failed to update record"]);
        }
    }

        public function destroy($id)
    {
            $user = $request->route()->parameter('user');
            $checkUser = User::find($id);
                 if($checkUser == null)
                    {
                        return response()->json(["error"=>"Couldn't find record"]);
                    }

            $currentUser=$user['id'];
            if($currentUser == $id)
            {
            return response()->json(["message"=>"cannaot delete logged in user"]);    
            }
        
        User::destroy($id);
        $user=User::find($id);
        if($user==null)
        {
            return response()->json(["message"=>"Record deleted successfully"]);
        }
    }
    

    public function create()
    {
        
    }
}