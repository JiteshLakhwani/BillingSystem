<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\Challan;
use App\ChallanDetail;
use \Validator;

class ChallanController extends Controller
{
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
            "challan_no" => 'required',
            "total_payable_amount" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $challan = Challan::create([
            "user_id" => $request->user_id,
            "firm_id" => $request->firm_id,
            "challan_no" => $request->challan_no,
            "challanYear" => $request->challanYear,
            "total_payable_amount" => $request->total_payable_amount,
            "created_at" => $request->created_at
        ]);
        $length = count($request->challan_detail);
        for ($i = 0; $i < $length; $i++) {
            ChallanDetail::create([
                 "product_id" => $request->challan_detail[$i]['product_id'],
                 "quantity" =>  $request->challan_detail[$i]['quantity'],
                 "price" => $request->challan_detail[$i]['price'],
                 "challan_id" => $challan['id'],
                 "discount_percentage" => $request->challan_detail[$i]['discount_percentage'],
                 "discount_amount" => $request->challan_detail[$i]['discount_amount'],
                 "size" => $request->challan_detail[$i]['size']

            ]);
}

//this will loop through challan detail and will return challan detail array 

$return_challandetail = array();
for ($i = 0; $i < $length; $i++) {
$return_challandetail[] = array(
        'hsn_code' => $challan->challandetail[$i]->product['hsn_code'],
        'product_name' => $challan->challandetail[$i]->product['product_name'],
        'price' => $challan->challandetail[$i]['price'],
        'discount_percentage' =>  number_format($challan->challandetail[$i]['discount_percentage'],2),
        'discount_amount' => number_format($challan->challandetail[$i]['discount_amount']),
        'size' => $challan->challandetail[$i]['size']

    );
}
        return response()->json(["user_id" => $challan['user_id'],
                                "username" => $challan->user['name'],
                                "challan_no" => $challan['challan_no'],
                                "challanYear" => $challan['challanYear'],
                                "firm_id" => $challan['firm_id'],
                                "firm_name" => $challan->firm['name'],
                                "total_payable_amount" => number_format($challan['total_payable_amount']),
                                "created_at" => $challan['created_at'],
                                "product_detail" => $return_challandetail
        ]);

    }

    public function index()
    {
        $challans = Challan::orderBy('challan_no','desc')->get();

        if(count($challans) == 0 )
            {
                return response()->json("", 204);
            }

        $return_challan = array();
        foreach ($challans as $challan)
        {
            $length = count($challan->challandetail);
            $return_challandetail = array();
            
            for ($i = 0; $i < $length; $i++) {
            $return_challandetail[] = array(
                'hsn_code' => $challan->challandetail[$i]->product['hsn_code'],
                'product_name' => $challan->challandetail[$i]->product['product_name'],
                'price' => $challan->challandetail[$i]['price'],
                'discount_percentage' => $challan->challandetail[$i]['discount_percentage'],
                'discount_amount' => $challan->challandetail[$i]['discount_amount'],
                'size' => $challan->challandetail[$i]['size']
    );
    }
            $return_challan [] = array(
                                "id" => $challan['id'],
                                "user_id" => $challan['user_id'],
                                "username" => $challan->user['name'],
                                "firm_id" => $challan['firm_id'],
                                "firm_name" => $challan->firm['name'],
                                "challan_no" => $challan['challan_no'],
                                "challanYear" => $challan['challanYear'],
                                "total_payable_amount" => $challan['total_payable_amount'],
                                "created_at" => $challan['created_at'],
                                "challandetail" => $return_challandetail
                
            );        }
        return response()->json($return_challan);

        
    }
   
}
