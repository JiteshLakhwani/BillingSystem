<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\CommonValidator\RequestValidator;
use App\Repositories\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    protected $requestValidator;

    public function __construct(ProductService $productService, RequestValidator $requestValidator){

        $this->productService = $productService;

        $this->requestValidator = $requestValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->productService->getAll();
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
                "product_name"=> 'required',
                "hsn_code"=> 'required|string',
                "product_price" => 'required|integer'
            ]);

        if($validate == "validatePass"){
        
            return  $this->productService->create($request);
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
                "product_name"=> 'required',
                "hsn_code"=> 'required|string',
                "product_price" => 'required|integer'
            ]);

        if($validate == "validatePass"){
            
            return $this->productService->update($id, $request); 
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
        return $this->productService->delete($id);
    }
}
