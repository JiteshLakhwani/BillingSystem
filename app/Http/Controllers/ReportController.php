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

        if(count($bills) == 0)
            {
                 return response()->json(["message" => "Data not found"]);
            }

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
            if(count($billinvoice) == 0)
            {
                 return response()->json(["message" => "bill not found"]);
            }

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
                    'size' => $bill->billdetail[$i]['size'],
                    'quantity' => $bill->billdetail[$i]['quantity']

    );
}
        return response()->json(["user_id" => $bill['user_id'],
                                "username" => $bill->user['name'],
                                "admin_firm" => $bill->user->adminfirm['name'],
                                "admin_gst" => $bill->user->adminfirm['gst_number'],
                                "admin_address" => $bill->user->adminfirm['address'],
                                "admin_cityname" => $bill->user->adminfirm['cityname'],
                                "admin_state" => $bill->user->adminfirm->state['state_name'],
                                "admin_pincode" => $bill->user->adminfirm['pincode'],
                                "admin_mobile_number" => $bill ->user->adminfirm['mobile_number'],
                                "admin_landline_number" => $bill ->user->adminfirm['landline_number'],

                                "firm_id" => $bill['firm_id'],
                                "firm_name" => $bill->firm['name'],
                                "customer_name" => $bill->firm['person_name'],
                                "customer_gst" => $bill->firm['gst_number'],
                                "customer_email" => $bill->firm['email'],
                                "shipping_address" => $bill->firm['shipping_address'],
                                "shipping_city" => $bill->firm['shipping_city'],
                                "shipping_state" => $bill->firm->shippingState['state_name'],
                                "shipping_pincode" => $bill->firm['shipping_pincode'],
                                "shipping_mobile_number" => $bill->firm['shipping_mobile_number'],
                                "shipping_landline_number" => $bill->firm['shipping_landline_number'],
                                "shipping_landline_number" => $bill->firm['shipping_landline_number'],

                                "billing_address" => $bill->firm['billing_address'],
                                "billing_city" => $bill->firm['billing_city'],
                                "billing_state" => $bill->firm->billingState['state_name'],
                                "billing_pincode" => $bill->firm['billing_pincode'],
                                "billing_mobile_number" => $bill->firm['billing_mobile_number'],
                                "billing_landline_number" => $bill->firm['billing_landline_number'],
                                "billing_landline_number" => $bill->firm['billing_landline_number'],

                                "id" => $bill['id'],
                                "invoice_no" => $bill['invoice_no'],
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
