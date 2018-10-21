<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\Bill;
use App\BillDetail;
use App\Repositories\Services\BillService;
use \Validator;

class BillController extends Controller
{
    protected $billService;
    
    public function __construct(BillService $billService){
        
        $this->billService = $billService;
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $bills = Bill::orderBy('invoice_no','desc')->get();

        //Find way to sort.

        if(count($bills) == 0 )
        {
            return response()->json(["message" => "No data found"]);
        }
        
        $return_bill = array();
        foreach ($bills as $bill)
        {
            $return_billdetail = array();
            
            for ($i = 0; $i < count($bill->billdetail); $i++) {
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
                "invoiceYear" => $bill['invoiceYear'],
                "gstNumber" => $bill->firm['gst_number'],
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
            );        
        }
        return response()->json($return_bill);
            
            
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
                "invoice_no" => 'required',
                "invoiceYear" => 'required',
                "taxable_amount" => 'required',
                "total_payable_amount" => "required"
                ]);
                
                if ($validator->fails()) {
                    return response()->json(["message" => $validator->errors()->all()], 400);
                }
                
                $billAndDetails = $this->billService->create($request);
                
                $billDetailArray = array();
                for ($i = 0; $i < count($billAndDetails[1]); $i++) {
                    $billDetailArray[] = array(
                        'hsn_code' => $billAndDetails[0]->billdetail[$i]->product['hsn_code'],
                        'product_name' => $billAndDetails[0]->billdetail[$i]->product['product_name'],
                        'price' => $billAndDetails[1][$i]['price'],
                        'discount_percentage' =>  number_format($billAndDetails[1][$i]['discount_percentage'],2),
                        'discount_amount' => number_format($billAndDetails[1][$i]['discount_amount']),
                        'size' => $billAndDetails[1][$i]['size']
                    );
                }
                return response()->json(["user_id" => $billAndDetails[0]['user_id'],
                    "username" => $billAndDetails[0]->user['name'],
                    "invoice_no" => $billAndDetails[0]['invoice_no'],
                    "invoiceYear" => $billAndDetails[0]['invoiceYear'],
                    "firm_id" => $billAndDetails[0]['firm_id'],
                    "firm_name" => $billAndDetails[0]->firm['name'],
                    "taxable_amount" => number_format($billAndDetails[0]['taxable_amount']),
                    "sgst_percentage" => number_format($billAndDetails[0]['sgst_percentage'],2),
                    "sgst_amount" => number_format($billAndDetails[0]['sgst_amount']),
                    "cgst_percentage" =>  number_format($billAndDetails[0]['cgst_percentage'],2),
                    "cgst_amount" => number_format($billAndDetails[0]['cgst_amount']),
                    "igst_percentage" =>  number_format($billAndDetails[0]['igst_percentage'],2),
                    "igst_amount" => number_format($billAndDetails[0]['igst_amount']),
                    "total_payable_amount" => number_format($billAndDetails[0]['total_payable_amount']),
                    "created_at" => $billAndDetails[0]['created_at'],
                    "product_detail" => $billDetailArray
                ]);
        }               
            /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function destroy($id)
            {               
                return $this->billService->delete($id);
            }     
        }