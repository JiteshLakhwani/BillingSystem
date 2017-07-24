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
                return response()->json(["error" => "No data in found"]);
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
        $this->verifyToken();

        $validator = Validator::make($request->all(), [
            "name" => 'required|string',
            "person_name" => 'required|string',
            "email" => 'required|email|max:255|unique:firms',
            "gst_number" => 'required',
            "bill_address" => 'required',
            "bill_city" => 'required|string',
            "bill_state_code" => 'required|string',
            "bill_pincode" => 'required|integer',
            "ship_address" => 'required',
            "ship_city" => 'required|string',
            "ship_state_code" => 'required|string',
            "ship_pincode" => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $user = Firm::create([
            "name" => $request->name,
            "person_name" => $request->person_name,
            "gst_number" => $request->gst_number,
            "email" => $request->email,
            "billing_address" => $request->bill_address,
            "billing_city" => $request->bill_city,
            "billing_state_code" => $request->bill_state_code,
            "billing_pincode" => $request->bill_pincode,
            "billing_mobile_number" => $request->bill_mobile_number,
            "billing_landline_number" =>  $request->bill_landline_number,

            "shipping_address" => $request->ship_address,
            "shipping_city" => $request->ship_city,
            "shipping_state_code" => $request->ship_state_code,
            "shipping_pincode" => $request->ship_pincode,
            "shipping_mobile_number" => $request->ship_mobile_number,
            "shipping_landline_number" =>  $request->ship_landline_number,
        ]);

        return response()->json($user);

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
            "name" => 'required|string|max:191',
            "person_name" => 'required|string|max:191',
            "gst_number" => 'required|min:15|max:15',
            "email" => 'required|email|max:191',
            "bill_address" => 'required|max:191',
            "bill_cityname" => 'required|string|max:191',
            "bill_state_code" => 'required|integer',
            "bill_pincode" => 'required|integer',
            "ship_address" => 'required|max:191',
            "ship_cityname" => 'required|string|max:191',
            "ship_state_code" => 'required|integer',
            "ship_pincode" => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $firm = Firm::where("id", $id)->update([
            "name" => $request->name,
            "person_name" => $request->person_name,
            "gst_number" => $request->gst_number,
            "email" => $request->email,
            "billing_address" => $request->bill_address,
            "billing_city" => $request->bill_cityname,
            "billing_state_code" => $request->bill_state_code,
            "billing_pincode" => $request->bill_pincode,
            "billing_mobile_number" => $request->bill_mobile_number,
            "billing_landline_number" =>  $request->bill_landline_number,
            "shipping_address" => $request->ship_address,
            "shipping_city" => $request->ship_cityname,
            "shipping_state_code" => $request->ship_state_code,
            "shipping_pincode" => $request->ship_pincode,
            "shipping_mobile_number" => $request->ship_mobile_number,
            "shipping_landline_number" =>  $request->ship_landline_number,

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
            $this->verifyToken();

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

    public function verifyToken()
    {
            try {
                if (! $user = JWTAuth::parseToken()->authenticate()) {
                    
                    return response()->json(['error' => 'Please verify your token'], 400);
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['error' => 'Token Expired'], 500);
            }
        }

    public function testing()
    {
        $firm = Firm::find(1);
       dd( $firm->shippingState->state_name);
    }
}
