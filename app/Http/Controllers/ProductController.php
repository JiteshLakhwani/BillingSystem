<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use \Validator;
use App\Repositories\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService){

        $this->productService = $productService;
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

            $validator = Validator::make($request->all(), [

                "product_name"=> 'required',
                "hsn_code"=> 'required|string',
                "product_price" => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json(["message" => $validator->errors()->all()], 400);
            }

           return  $this->productService->create($request);
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

                "product_name"=> 'required',
                "hsn_code"=> 'required|string',
                "product_price" => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json(["message" => $validator->errors()->all()], 400);
            }

           return $this->productService->update($id, $request);            
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
