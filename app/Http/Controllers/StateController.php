<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\CommonValidator\RequestValidator;
use App\Repositories\Services\StateService;

class StateController extends Controller{
    
    protected $stateService;

    protected $requestValidator;

    /**
     * Create instances of 2 class stateService and RequestValidator.
     *
     * @param  App\Repositories\Services\stateService  $stateService
     * @param @param  App\Http\CommonValidator\RequestValidator  $requestValidator
     * 
     */

    public function __construct(StateService $stateService, RequestValidator $requestValidator){

        $this->stateService = $stateService;

        $this->requestValidator = $requestValidator;
    }

    /**
     * Display a listing of the all the States Available.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return $this->stateService->getAll();
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

            "state_code"=> 'required|integer|unique:states',
            "state_name"=> 'required|string'
        ]);
        
        if($validate == "validatePass"){
            
            return  $this->stateService->create($request);
        }

        return $validate;
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
        $validate = $this->requestValidator->validateRequest($request, [

            "state_code"=> 'required|integer|unique:states',
            "state_name"=> 'required|string'
        ]);
        
        if($validate == "validatePass"){
            
            return $this->stateService->update($id, $request);
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
        return $this->stateService->delete($id);
    }
}
