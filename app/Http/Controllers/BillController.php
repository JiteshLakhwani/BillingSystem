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
        $bills = Bill::orderBy('invoice_no','desc')->get();

        if(count($bills) == 0 )
            {
                return response()->json(["message" => "No data found"]);
            }

        $return_bill = array();
        foreach ($bills as $bill)
        {
            
            $length = count($bill->billdetail);
            $return_billdetail = array();
            
            for ($i = 0; $i < $length; $i++) {
            $return_billdetail[] = array(
                'hsn_code' => $bill->billdetail[$i]->product['hsn_code'],
                'product_name' => $bill->billdetail[$i]->product['product_name'],
                'price' => $bill->billdetail[$i]['price'],
                'discount_percentage' => $bill->billdetail[$i]['discount_percentage'],
                'discount_amount' => $bill->billdetail[$i]['discount_amount'],
                'size' => $bill->billdetail[$i]['size']
    );
    }
            $return_bill [] = array(
                                "id" => $bill['id'],
                                "user_id" => $bill['user_id'],
                                "username" => $bill->user['name'],
                                "firm_id" => $bill['firm_id'],
                                "firm_name" => $bill->firm['name'],
                                "invoice_no" => $bill['invoice_no'],
                                "taxable_amount" => $bill['taxable_amount'],
                                "sgst_percentage" => $bill['sgst_percentage'],
                                "sgst_amount" => $bill['sgst_amount'],
                                "cgst_percentage" => $bill['cgst_percentage'],
                                "cgst_amount" => $bill['cgst_amount'],
                                "igst_percentage" => $bill['igst_percentage'],
                                "igst_amount" => $bill['igst_amount'],
                                "total_payable_amount" => $bill['total_payable_amount'],
                                "created_at" => $bill['created_at'],
                                "billdetail" => $return_billdetail
                
            );        }
        return response()->json($return_bill);

        
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
            "user_id" => 'required',
            "firm_id" => 'required',
            "invoice_no" => 'required|unique:bills',
            "taxable_amount" => 'required',
            "total_payable_amount" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }
        // $invoice = Bill::find($request->invoice_no);
        // if($invoice == 1){
        //     return response()->json(["message"=>"Invoice number already occupied"]);
        // }

        $bill = Bill::create([
            "user_id" => $request->user_id,
            "firm_id" => $request->firm_id,
            "invoice_no" => $request->invoice_no,
            "invoiceYear" => $request->invoiceYear,
            "taxable_amount" => $request->taxable_amount,           
            "sgst_percentage" => $request->sgst_percentage,
            "sgst_amount" => $request->sgst_amount,
            "cgst_percentage" => $request->cgst_percentage,
            "cgst_amount" => $request->cgst_amount,
            "igst_percentage" => $request->igst_percentage,
            "igst_amount" => $request->igst_amount,
            "total_payable_amount" => $request->total_payable_amount,
            "created_at" => $request->created_at
        ]);
        $length = count($request->bill_detail);
        for ($i = 0; $i < $length; $i++) {
            BillDetail::create([
                 "product_id" => $request->bill_detail[$i]['product_id'],
                 "quantity" =>  $request->bill_detail[$i]['quantity'],
                 "price" => $request->bill_detail[$i]['price'],
                 "bill_id" => $bill['id'],
                 "discount_percentage" => $request->bill_detail[$i]['discount_percentage'],
                 "discount_amount" => $request->bill_detail[$i]['discount_amount'],
                 "size" => $request->bill_detail[$i]['size']

            ]);
}

//this will loop through bill detail and will return bill detail array 

$return_billdetail = array();
for ($i = 0; $i < $length; $i++) {
$return_billdetail[] = array(
        'hsn_code' => $bill->billdetail[$i]->product['hsn_code'],
        'product_name' => $bill->billdetail[$i]->product['product_name'],
        'price' => $bill->billdetail[$i]['price'],
        'discount_percentage' =>  number_format($bill->billdetail[$i]['discount_percentage'],2),
        'discount_amount' => number_format($bill->billdetail[$i]['discount_amount']),
        'size' => $bill->billdetail[$i]['size']

    );
}
        return response()->json(["user_id" => $bill['user_id'],
                                "username" => $bill->user['name'],
                                "invoice_no" => $bill['invoice_no'],
                                "invoiceYear" => $bill['invoiceYear'],
                                "firm_id" => $bill['firm_id'],
                                "firm_name" => $bill->firm['name'],
                                "taxable_amount" => number_format($bill['taxable_amount']),
                                "sgst_percentage" => number_format($bill['sgst_percentage'],2),
                                "sgst_amount" => number_format($bill['sgst_amount']),
                                "cgst_percentage" =>  number_format($bill['cgst_percentage'],2),
                                "cgst_amount" => number_format($bill['cgst_amount']),
                                "igst_percentage" =>  number_format($bill['igst_percentage'],2),
                                "igst_amount" => number_format($bill['igst_amount']),
                                "total_payable_amount" => number_format($bill['total_payable_amount']),
                                "created_at" => $bill['created_at'],
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
            $bill = Bill::find($id);
            if($bill == null)
            {
                return response()->json(["error"=>"Couldn't find record"]);
            }
            
            $bill->delete();

            $bill = Bill::find($id);
            if($bill==null)
            {
                return response()->json(["message"=>"Record deleted successfuly"]);
            }
    }     
}