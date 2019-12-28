<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\CommonValidator\RequestValidator;
use App\User;
use App\Repositories\Services\AdminFirmService;


class UserDetailController extends Controller
{

    protected $requestValidator;

    protected $adminFirmService;

    public function __construct(AdminFirmService $adminFirmService, RequestValidator $requestValidator){

        $this->adminFirmService = $adminFirmService;

        $this->requestValidator = $requestValidator;
    }

    public function index(Request $request)
    {

        return $this->adminFirmService->read($request);
    }


    public function update(Request $request, $id) {
        
        $validate = $this->requestValidator->validateRequest($request, [
            "username" => 'required|string',
            "email" => 'required|email|max:255',

            "firmName" => 'required|string',
            "gst_number" => 'required|min:15|max:15',
            "address" => 'required',
            "cityname" => 'required|string',
            "state_code" => 'required|integer',
            "pincode" => 'required|integer'
        ]);

        if ($validate == "validatePass") {

            return $this->adminFirmService->update($id, $request);
        }

        return $validate;
    }

    public function destroy($id)
    {
        return $this->adminFirmService->delete($id);
    }
    
    public function store(Request $request)
    {
        $validate = $this->requestValidator->validateRequest($request, [
            "name" => 'required',
            "email" => 'required|unique:users',
            "password" => 'required',
            
        ]);

        if ($validate == "validatePass") {

            return $this->adminFirmService->create($request->only(['name', 'email', 'password']));
        }
        
        return $validate;
    }

    public function updatePassword(Request $request){
        $user = $request->route()->parameter('user');

        $pass = User::where("email", $user['email'])->update([
            "password" => bcrypt($request->password)
        ]);

        if($pass == 1) {

            return response()->json('Password successfully updated');
            }
        else{

            return response()->json('Password not updated');
            }
    }
}