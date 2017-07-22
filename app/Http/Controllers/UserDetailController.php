<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;

class UserDetailController extends Controller
{
    //     public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function show()
    {
        
 try {
            // attempt to verify the credentials and create a token for the user
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                
                return response()->json(['error' => 'Token Not Available'], 400);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'No Token Found'], 500);
        }

                 return Response::json(['username'=> $user['admin_name'],
                                        'firm name' =>$user['firm_name'],
                                        'email'=> $user['email'],
                                        'address'=> $user['address'],
                                        'city'=> $user['city'],
                                        'state'=> $user['state'],
                                        'state code'=> $user['state_code'],
                                        'pin code' => $user['pin_code'],
                                        'mobile number' => $user ['mobile_number'],
                                        'landline'=> $user['landline'],
                                        'GST number'=> $user['gst_number']
        ]);
    }
}
