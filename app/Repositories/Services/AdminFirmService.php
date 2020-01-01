<?php 

namespace App\Repositories\Services;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\AdminFirmInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Http\Resources\UserResource;

class AdminFirmService {

    protected $adminFirmInterface;

    protected $userInterface;

    public function __construct(AdminFirmInterface $adminFirmInterface, UserInterface $userInterface){

        $this->adminFirmInterface = $adminFirmInterface;

        $this->userInterface = $userInterface;
    }

    public function read($request){

        $user = $request->route()->parameter('user');

        return new UserResource($user);
    }

    public function update($id, Request $request){

        $this->userInterface->update($id, [
                "name" => $request->username 
            ]);
        $user = $this->userInterface->find($id);

       if($this->adminFirmInterface->update($user['adminfirm_id'], $this->getAdminFirmArray($request)) == true){

            return new UserResource($user);
       }

       return response()->json(["message" => "Failed to update record"]);

    }

    public function delete($id){
    
        if($this->userInterface->find($id) == null)
           {
               return response()->json(["error"=>"Couldn't find record"]);
        }
        
        if($this->userInterface->delete($id) == true){

            return response()->json(["message"=>"Record deleted successfully"]);
        }
    }

    public function create($request){

        if($this->userInterface->create($request) == false){

            return response()->json(["error"=>"Couldn't create record"]);
        }

        return response()->json([
            "name" => $request['name'],
            "email" => $request['email'],
            "password" => $request['password'],
            "adminfirm_id" => $request['adminfirm_id']
        ]);
    }

    public function getAdminFirmArray($request){

        return array(
            "name" => $request->firmName,
            "email" => $request->email,
            "gst_number" => $request->gst_number,
            "address" => $request->address,
            "cityname" => $request->cityname,
            "state_code" => $request->state_code,
            "pincode" => $request->pincode,
            "mobile_number" => $request->mobile_number,
            "landline_number" =>  $request->landline_number,
            "bank_name" => $request->bank_name,
            "branch_name" => $request->branch_name,
            "ifsc_code" => $request->ifsc_code,
            "account_no" => $request->account_no
        );
    }
}