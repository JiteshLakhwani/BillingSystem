<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FirmReportResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {

        $return_bill = array();
        $return_billdetail = array();

        for($i = 0; $i < count($this->bill); $i++){

            for ($j = 0; $j < count($this->bill[$i]->billdetail); $j++) {
                
                $return_billdetail[] = array(
                    'hsn_code' => $this->bill[$i]->billdetail[$j]->product['hsn_code'],
                    'product_name' => $this->bill[$i]->billdetail[$j]->product['product_name'],
                    'price' => $this->bill[$i]->billdetail[$j]['price'],
                    'discount_percentage' =>  number_format($this->bill[$i]->billdetail[$j]['discount_percentage'],2),
                    'discount_amount' => number_format($this->bill[$i]->billdetail[$j]['discount_amount']),
                    'size' => $this->bill[$i]->billdetail[$j]['size'],
                    'quantity' => $this->bill[$i]->billdetail[$j]['quantity']);
                }
                    
        $return_bill[] = array(
            'invoice_no' => $this->bill[$i]['invoice_no'],
            'taxable_amount' => $this->bill[$i]['taxable_amount'],
            'sgst_percentage' => $this->bill[$i]['sgst_percentage'],
            'sgst_amount' => $this->bill[$i]['sgst_amount'],
            'cgst_percentage' => $this->bill[$i]['cgst_percentage'],
            'cgst_amount' => $this->bill[$i]['cgst_amount'],
            'igst_percentage' => $this->bill[$i]['igst_percentage'],
            'igst_amount' => $this->bill[$i]['igst_amount'],
            'total_payable_amount' => $this->bill[$i]['total_payable_amount'],
            'bill_details' =>  $return_billdetail
            );

            $return_billdetail = null;
        }

        return [
            "id" => $this->id,
            "firm_name" => $this->name,
            "customer_name" => $this->person_name,
            "customer_gst" => $this->gst_number,
            "customer_email" => $this->email,
            "shipping_address" => $this->shipping_address,
            "shipping_city" => $this->shipping_city,
            "shipping_state_code" => $this->shipping_state_code,
            "shipping_state" => $this->shippingState['state_name'],
            "shipping_pincode" => $this->shipping_pincode,
            "shipping_mobile_number" => $this->shipping_mobile_number,
            "shipping_landline_number" => $this->shipping_landline_number,
            "shipping_landline_number" => $this->shipping_landline_number,
        
            "billing_address" => $this->billing_address,
            "billing_city" => $this->billing_city,
            "billing_state_code" => $this->billing_state_code,
            "billing_state" => $this->billingState['state_name'],
            "billing_pincode" => $this->billing_pincode,
            "billing_mobile_number" => $this->billing_mobile_number,
            "billing_landline_number" => $this->billing_landline_number,
            "billing_landline_number" => $this->billing_landline_number,
            "bills" => $return_bill

        ];

        /*DISCUSS TWO WAYS of RETURNING OF DATA 
        * 1) Pass the way it is  
        * 2) Pass it inside Object
        *   - "admin_Details"=> $this->user->adminFirm
        */ 

    }
}
