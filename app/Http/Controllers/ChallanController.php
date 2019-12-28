<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\Services\ChallanService;
use App\Http\CommonValidator\RequestValidator;

class ChallanController extends Controller
{

    protected $requestValidator;

    protected $challanService;


    public function __construct(RequestValidator $requestValidator, ChallanService $challanService){

        $this->requestValidator = $requestValidator;

        $this->challanService = $challanService;

    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = $this->requestValidator->validateRequest($request, [
            "user_id" => 'required',
            "firm_id" => 'required',
            "challan_no" => 'required',
            "total_payable_amount" => "required"
        ]);

        if ($validate == "validatePass") {
        
            return $this->challanService->store($request);
        }

        return $validate;
    }

    public function index()
    {

        return $this->challanService->getAll();    
    }
   
}
