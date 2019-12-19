<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\Services\FirmService;
use App\Http\CommonValidator\RequestValidator;
class FirmController extends Controller
{
    protected $requestValidator;

    protected $firmService;
    
    public function __construct(FirmService $firmService, RequestValidator $requestValidator){

        $this->firmService = $firmService;

        $this->requestValidator = $requestValidator;
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
        
        $validate = $this->$requestValidator->validateRequest($request, [
            "name" => 'required|string',
            "person_name" => 'required|string',
            "billing_address" => 'required',
            "billing_city" => 'required|string',
            "billing_state_code" => 'required|integer',
            "shipping_address" => 'required',
            "shipping_city" => 'required|string',
            "shipping_state_code" => 'required|integer',
            ]);
            
        if ($validate == "validatePass") {

            return $this->firmService->create($request);
        }

        return $validate;
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
        $validate = $this->$requestValidator->validateRequest($request, [
            "name" => 'required|string|max:191',
            "person_name" => 'required|string|max:191',
            "billing_address" => 'required|max:191',
            "billing_city" => 'required|string|max:191',
            "billing_state_code" => 'required|integer',
            "shipping_address" => 'required|max:191',
            "shipping_city" => 'required|string|max:191',
            "shipping_state_code" => 'required|integer'
        ]);
        
        if ($validate == "validatePass") {

            return $this->firmService->update($request, $id);
        }           
        
        return $validate;
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
}
            