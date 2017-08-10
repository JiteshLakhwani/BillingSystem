<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\Firm;
use \Validator;
class FirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $firms = Firm::get();
            if($firms->count() == 0 )
            {
                return response()->json(["message" => "No data found"]);
            }
            return response()->json(["Firms"=>$firms],200);

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

        $validator = Validator::make($request->all(), [
            "name" => 'required|string',
            "person_name" => 'required|string',
            "email" => 'required|email|max:255|unique:firms',
            "gst_number" => 'required',
            "billing_address" => 'required',
            "billing_city" => 'required|string',
            "billing_state_code" => 'required|integer',
            "billing_pincode" => 'required|integer',
            "shipping_address" => 'required',
            "shipping_city" => 'required|string',
            "shipping_state_code" => 'required|integer',
            "shipping_pincode" => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $firm = Firm::create([
            "name" => $request->name,
            "person_name" => $request->person_name,
            "gst_number" => $request->gst_number,
            "email" => $request->email,
            "billing_address" => $request->billing_address,
            "billing_city" => $request->billing_city,
            "billing_state_code" => $request->billing_state_code,
            "billing_pincode" => $request->billing_pincode,
            "billing_mobile_number" => $request->billing_mobile_number,
            "billing_landline_number" =>  $request->billing_landline_number,

            "shipping_address" => $request->shipping_address,
            "shipping_city" => $request->shipping_city,
            "shipping_state_code" => $request->shipping_state_code,
            "shipping_pincode" => $request->shipping_pincode,
            "shipping_mobile_number" => $request->shipping_mobile_number,
            "shipping_landline_number" =>  $request->shipping_landline_number,
        ]);

        return response()->json(["name" => $firm['name'],
                                "person_name" =>$firm['person_name'],
                                "gst_number" =>$firm['gst_number'],
                                "email" =>$firm['email'],
                                "billing_address" =>$firm['billing_address'],
                                "billing_state_name" => $firm->billingState['state_name'],
                                "billing_state_code" => $firm['state_code'],
                                "billing_city" =>$firm['billing_city'],
                                "billing_pincode" =>$firm['billing_pincode'],
                                "billing_mobile_number" =>$firm['billing_mobile_number'],
                                "billing_mobile_number" =>$firm['billing_landline_number'],

                                "shipping_address" =>$firm['shipping_address'],
                                "shipping_state_name" => $firm->shippingState['state_name'],
                                "shipping_state_code" => $firm['shipping_state_code'],
                                "shipping_city" =>$firm['shipping_city'],
                                "shipping_pincode" =>$firm['shipping_pincode'],
                                "shipping_mobile_number" =>$firm['shipping_mobile_number'],
                                "shipping_mobile_number" =>$firm['shipping_landline_number']],200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $firm = Firm::find($id);
            if($firm->count() == 0 )
            {
                return response()->json(["message" => "No data found"]);
            }
        return response()->json($firm);
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
            $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:191',
            "person_name" => 'required|string|max:191',
            "gst_number" => 'required|min:15|max:15',
            "email" => 'required|email|max:191',
            "billing_address" => 'required|max:191',
            "billing_city" => 'required|string|max:191',
            "billing_state_code" => 'required|integer',
            "billing_pincode" => 'required|integer',
            "shipping_address" => 'required|max:191',
            "shipping_city" => 'required|string|max:191',
            "shipping_state_code" => 'required|integer',
            "shipping_pincode" => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $firm = Firm::where("id", $id)->update([
            "name" => $request->name,
            "person_name" => $request->person_name,
            "gst_number" => $request->gst_number,
            "email" => $request->email,
            "billing_address" => $request->billing_address,
            "billing_city" => $request->billing_city,
            "billing_state_code" => $request->billing_state_code,
            "billing_pincode" => $request->billing_pincode,
            "billing_mobile_number" => $request->billing_mobile_number,
            "billing_landline_number" =>  $request->billing_landline_number,
            "shipping_address" => $request->shipping_address,
            "shipping_city" => $request->shipping_city,
            "shipping_state_code" => $request->shipping_state_code,
            "shipping_pincode" => $request->shipping_pincode,
            "shipping_mobile_number" => $request->shipping_mobile_number,
            "shipping_landline_number" =>  $request->shipping_landline_number,

        ]);
        if($firm==1)
        {
             $firm = Firm::find($id);
             
                 return Response::json($firm);
        }
        else{
            return response()->json(["message" => "Failed to update record"]);
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

            $firm = Firm::find($id);
            if($firm == null)
            {
                return response()->json(["error"=>"Couldn't find record"]);
            }
            Firm::destroy($id);
            $firm=Firm::find($id);
            if($firm==null)
            {
                return response()->json(["message"=>"Record deleted successfuly"]);
            }
    }
     
       public function lists()
    {

        $firms = Firm::get();
       foreach($firms as $firm)
            {
                $response ['firms'][]= ['id' => $firm->id,
                            'firm_name' =>$firm->name,
                            'state_code'=>$firm->billing_state_code
                ];
            }
            return response()->json($response,200);
    }
}
