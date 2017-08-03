<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\Bill;
use \Validator;

class ReportController extends Controller
{
     public function BetweenDates(Request $request)
    {
        try {
                if (! $user = JWTAuth::parseToken()->authenticate()) {

                    return response()->json(['error' => 'Please verify your token'], 400);
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['error' => 'Token Expired'], 500);
            }

            $validator = Validator::make($request->all(), [
            "start_date" => 'required',
            "end_date" => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $first_date = date('Y-m-d',strtotime($request->start_date));
        $last_date = date('Y-m-d',strtotime($request->end_date));
        $bills = Bill::whereBetween('created_at', [$first_date, $last_date])->get();

        $return_bill = array();
        foreach ($bills as $bill)
        {
            $length = count($bill->billdetail);
            $return_billdetail = array();

            for ($i = 0; $i < $length; $i++) {
            $return_billdetail[] = array('hsn_code' => $bill->billdetail[$i]->product['hsn_code'],
                                            'product_name' => $bill->billdetail[$i]->product['product_name'],
                                            'price' => $bill->billdetail[$i]['price'],
                                            'discount_percentage' => $bill->billdetail[$i]['discount_percentage'],
                                            'discount_amount' => $bill->billdetail[$i]['discount_amount'],
                                            'size' => $bill->billdetail[$i]['size']);
            }
            $return_bill[] = array("id" => $bill['id'],
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
                                "billdetail" => $return_billdetail);

        }
        return response()->json($return_bill);
    }

    public function singleBill($invoice)
    {
                try {
                if (! $user = JWTAuth::parseToken()->authenticate()) {

                    return response()->json(['error' => 'Please verify your token'], 400);
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['error' => 'Token Expired'], 500);
            }
            
            $billinvoice = Bill::where('invoice_no',$invoice)->get();
            $bill = Bill::find($billinvoice[0]['id']);
            $length = count($bill->billdetail);

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
        return response()->json(["id" => $bill['id'],
                                "user_id" => $bill['user_id'],
                                "username" => $bill->user['name'],
                                "invoice_no" => $bill['invoice_no'],
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

    public function lastInvoice()
    {
         $bill = Bill::get()->last();

        return response()->json($bill['invoice_no']);
    }
}
