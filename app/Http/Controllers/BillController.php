<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\Services\BillService;
use App\Http\CommonValidator\RequestValidator;

class BillController extends Controller
{
    protected $requestValidator;

    protected $billService;
    
    public function __construct(BillService $billService, RequestValidator $requestValidator){

        $this->requestValidator = $requestValidator;
        
        $this->billService = $billService;
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(){

        return $this->billService->getAll();            
    }
        
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {

        $validate = $this->requestValidator->validateRequest($request, [
            "user_id" => 'required',
            "firm_id" => 'required',
            "invoice_no" => 'required',
            "invoiceYear" => 'required',
            "taxable_amount" => 'required',
            "total_payable_amount" => "required"
        ]);
                
        if ($validate == "validatePass") {
        
            return $this->billService->create($request);
        }
        
        return $validate;
    }               
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id){
        
        return $this->billService->delete($id);
    }     
}