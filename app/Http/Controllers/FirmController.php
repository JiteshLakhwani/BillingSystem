<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\Services\FirmService;
use \Validator;
class FirmController extends Controller
{
    protected $firmService;
    
    public function __construct(FirmService $firmService){
        $this->firmService = $firmService;
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return $this->firmService->index();
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            "name" => 'required|string',
            "person_name" => 'required|string',
            "billing_address" => 'required',
            "billing_city" => 'required|string',
            "billing_state_code" => 'required|integer',
            "shipping_address" => 'required',
            "shipping_city" => 'required|string',
            "shipping_state_code" => 'required|integer',
            ]);
            
            if ($validator->fails()) {
                return response()->json(["message" => $validator->errors()->all()], 400);
            }
            
        return $this->firmService->create($request);
    }
            
            
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {            
        return $this->firmService->read($id);      
    }
  
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:191',
            "person_name" => 'required|string|max:191',
            "billing_address" => 'required|max:191',
            "billing_city" => 'required|string|max:191',
            "billing_state_code" => 'required|integer',
            "shipping_address" => 'required|max:191',
            "shipping_city" => 'required|string|max:191',
            "shipping_state_code" => 'required|integer'
        ]);
        
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }           
        return $this->firmService->update($request, $id);
    }
                    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        return $this->firmService->delete($id);  
    }
                    
    public function lists()
    {    
        return $this->firmService->listCustomer();
    }
}
            