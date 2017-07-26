<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use \Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $this->verifyToken();
            $products = Product::get();
            if($products->count() == 0 )
            {
                return response()->json(["error" => "No data available"]);
            }
            foreach($products as $product)
            {
                $response ['products'][]= ['id' => $product->id,
                            'product_name' =>$product->product_name,
                            'hsn_code' =>$product->hsn_code,
                            'product_price'=>$product->product_price
                ];
            }
            return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->verifyToken();

            $validator = Validator::make($request->all(), [

                "product_name"=> 'required',
                "hsn_code"=> 'required|string',
                "product_price" => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json(["message" => $validator->errors()->all()], 400);
            }
                $product = Product::create([
                "product_name" => $request->product_name,
                "hsn_code" => $request->hsn_code,
                "product_price" => $request->product_price
            ]);

            return response()->json(["id" => $product->id,
                                     "product_name" => $product->product_name,
                                     "hsn_code" => $product->hsn_code,
                                     "product_price" => $product->product_price]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
               $this->verifyToken();

            $validator = Validator::make($request->all(), [

                "product_name"=> 'required',
                "hsn_code"=> 'required|string',
                "product_price" => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json(["message" => $validator->errors()->all()], 400);
            }

    
                $product = Product::where("id", $id)->update([
                    "product_name" => $request->product_name,
                     "hsn_code" => $request->hsn_code,
                     "product_price" => $request->product_price
            ]);

            if($product==1)
            {
                $updatedProduct = Product::find($id);
                return response()->json(["id" => $updatedProduct->id,
                                        "product_name" => $updatedProduct->product_name,
                                        "hsn_code" => $updatedProduct->hsn_code,
                                        "product_price" => $updatedProduct->product_price]);
            }
            else
            {
                return response()->json(["message"=>"Couldn't update the data"]);
            }
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
             $this->verifyToken();

            $product = Product::find($id);
            if($product == null)
            {
                return response()->json(["error"=>"Couldn't find record"]);
            }
            Product::destroy($id);
            $product=Product::find($id);
            if($product==null)
            {
                return response()->json(["message"=>"Record deleted successfuly"]);
            }
    }

     public function verifyToken()
        {
                try {
                if (! $user = JWTAuth::parseToken()->authenticate()) {
                    
                    return response()->json(['error' => 'Token Not Available'], 400);
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['error' => 'Token Expired'], 500);
            }

        }
}
