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
use App\Repositories\Services\AdminFirmService;


class UserDetailController extends Controller
{

    protected $adminFirmService;

    public function __construct(AdminFirmService $adminFirmService){

        $this->adminFirmService = $adminFirmService;
    }

    public function show(Request $request)
    {

        return $this->adminFirmService->read($request);
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

        return $this->adminFirmService->update($id, $request);
    }

        public function destroy($id)
    {
        return $this->adminFirmService->delete($id);
    }
    
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|unique:users',
            "password" => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        return $this->adminFirmService->create($request->only(['name', 'email', 'password']));
    }

    public function updatePassword(Request $request)
    {
        $user = $request->route()->parameter('user');

        $pass = User::where("email", $user['email'])->update([
            "password" => bcrypt($request->password)
    ]);

        if($pass == 1)
        {
            return response()->json('Password successfully updated');
        }
        else
        {
            return response()->json('Password not updated');
        }
    }
}