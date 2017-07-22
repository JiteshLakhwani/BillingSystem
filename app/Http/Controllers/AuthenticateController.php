<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;

class AuthenticateController extends Controller
{
     public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email','password');
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    // public function login()
    // {
    //      return Response::json([
    //         'error' =>['message'=> 'Login into System']
    //     ],440);
    // }

        public function checkAuthentication()
    {
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);
        return $user;
    }
}
