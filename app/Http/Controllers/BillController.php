<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\Bill;
use App\BillDetail;
use \Validator;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            "user_id" => 'required',
            "firm_id" => 'required',
            "taxable_amount" => 'required',
            "total_payable_amount" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $bill = Bill::create([
            "user_id" => $request->user_id,
            "firm_id" => $request->firm_id,
            "taxable_amount" => $request->taxable_amount,
            "sgst_percentage" => $request->sgst_percentage,
            "sgst_amount" => $request->sgst_amount,
            "cgst_percentage" => $request->cgst_percentage,
            "cgst_amount" => $request->cgst_amount,
            "igst_percentage" => $request->igst_percentage,
            "igst_amount" => $request->sgst_amount,
            "total_payable_amount" => $request->total_payable_amount
        ]);

        $length = count($request->bill_detail);

        for ($i = 0; $i < $length; $i++) {
            BillDetail::create([
                 "product_id" => $request->bill_detail[$i]['product_id'],
                 "quantity" =>  $request->bill_detail[$i]['quantity'],
                 "price" => $request->bill_detail[$i]['price'],
                 "bill_id" => $bill['id']
            ]);
}

//this will loop through bill detail and will return bill detail array 

$return_billdetail = array();
for ($i = 0; $i < $length; $i++) {
$return_billdetail[] = array(
        'hsn_code' => $bill->billdetail[$i]->product['hsn_code'],
        'product_name' => $bill->billdetail[$i]->product['product_name'],
        'price' => $bill->billdetail[$i]['price']
    );
}
        return response()->json(["user_id" => $bill['user_id'],
                                "firm_id" => $bill['firm_id'],
                                "taxable_amount" => $bill['taxable_amount'],
                                "sgst_percentage" => $bill['sgst_percentage'],
                                "sgst_amount" => $bill['sgst_amount'],
                                "cgst_percentage" => $bill['cgst_percentage'],
                                "cgst_amount" => $bill['cgst_amount'],
                                "igst_percentage" => $bill['igst_percentage'],
                                "igst_amount" => $bill['igst_amount'],
                                "total_payable_amount" => $bill['total_payable_amount'],
                                "product_detail" => $return_billdetail
        ]);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}
