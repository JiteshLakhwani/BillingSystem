<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\Bill;
use App\Firm;
use \Validator;
use Carbon\Carbon;
use \DB;

class ReportController extends Controller
{
    
     public function BetweenDates(Request $request)
    {
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
                                "admin_email" => $bill ->user->adminfirm['email'],
                                "admin_address" => $bill->user->adminfirm['address'],
                                "admin_cityname" => $bill->user->adminfirm['cityname'],
                                "admin_state" => $bill->user->adminfirm->state['state_name'],
                                "admin_state_code" => $bill->user->adminfirm['state_code'],
                                "admin_pincode" => $bill->user->adminfirm['pincode'],
                                "admin_mobile_number" => $bill ->user->adminfirm['mobile_number'],
                                "admin_landline_number" => $bill ->user->adminfirm['landline_number'],
                                "admin_bank_name" => $bill ->user->adminfirm['bank_name'],
                                "admin_branch_name" => $bill ->user->adminfirm['branch_name'],
                                "admin_ifsc_code" => $bill ->user->adminfirm['ifsc_code'],
                                "admin_account_no" => $bill ->user->adminfirm['account_no'],
                                

                                "firm_id" => $bill['firm_id'],
                                "firm_name" => $bill->firm['name'],
                                "customer_name" => $bill->firm['person_name'],
                                "customer_gst" => $bill->firm['gst_number'],
                                "customer_email" => $bill->firm['email'],
                                "shipping_address" => $bill->firm['shipping_address'],
                                "shipping_city" => $bill->firm['shipping_city'],
                                "shipping_state" => $bill->firm->shippingState['state_name'],
                                "shipping_state_code" => $bill->firm['shipping_state_code'],
                                "shipping_pincode" => $bill->firm['shipping_pincode'],
                                "shipping_mobile_number" => $bill->firm['shipping_mobile_number'],
                                "shipping_landline_number" => $bill->firm['shipping_landline_number'],
                                "shipping_landline_number" => $bill->firm['shipping_landline_number'],

                                "billing_address" => $bill->firm['billing_address'],
                                "billing_city" => $bill->firm['billing_city'],
                                "billing_state" => $bill->firm->billingState['state_name'],
                                "billing_state_code" => $bill->firm['billing_state_code'],
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

    public function firmName($name){
        $firm = Firm::where('name',$name)->get();

        if(count($firm) == 0)
            {
                 return response()->json(["message" => "firm not found"]);
            }
        $total_bill = count($firm[0]->bill);
        foreach($firm[0]->bill as $oneBill){
        }
        return response()->json($firm[0]->bill[1]->billdetail);
    }

    public function nextInvoice()
    {
         $count = Bill::get()->count();
         if($count==0){
             $invoiceNumber = 1;
             return response()->json(['invoiceNumber' => $invoiceNumber]);
         }
    
        $invoiceNumber = 1;
        while(true){
            if(Bill::get()->where('invoice_no','=',$invoiceNumber)->count() == 0){
                return response()->json($invoiceNumber);     
        }
        else{
            $invoiceNumber++;
        }
    }
    }

    public function weekSale()
    {
        $AgoDate=Carbon::now()->subWeek()->format('Y-m-d');  
        
        $NowDate=Carbon::now()->format('Y-m-d');  
       
        $bills = Bill::whereBetween('created_at', [$AgoDate,$NowDate])->groupBy('date')
                            ->orderBy('date')
                            ->get(array(
                                DB::raw('Date(created_at) as date'),
                                DB::raw('SUM(total_payable_amount) as "sale"')
                            ));;
        
        $retun_array = array();
        foreach ($bills as $bill)
        {
            $retun_array[] = array($bill['date'] => $bill['sale']);
        }

        return response()->json(['weeksale' => $retun_array]);
    }
public function monthSale()
    {
        $AgoDate=Carbon::now()->subMonth()->format('Y-m-d');  
        
        $NowDate=Carbon::now()->format('Y-m-d');  
       
        $bills = Bill::whereBetween('created_at', [$AgoDate,$NowDate])->groupBy('date')
                            ->orderBy('date')
                            ->get(array(
                                DB::raw('Date(created_at) as date'),
                                DB::raw('SUM(total_payable_amount) as "sale"')
                            ));;
        
        $retun_array = array();
        foreach ($bills as $bill)
        {
            $retun_array[] = array($bill['date'] => $bill['sale']);
        }

        return response()->json(['weeksale' => $retun_array]);
    }
}
