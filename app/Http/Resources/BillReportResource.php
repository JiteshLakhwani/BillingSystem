<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BillReportResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "user_id" => $this->user_id,
            "username" => $this->user['name'],
            "admin_firm" => $this->user->adminfirm['name'],
            "admin_gst" => $this->user->adminfirm['gst_number'],
            "admin_email" => $this ->user->adminfirm['email'],
            "admin_address" => $this->user->adminfirm['address'],
            "admin_cityname" => $this->user->adminfirm['cityname'],
            "admin_state" => $this->user->adminfirm->state['state_name'],
            "admin_state_code" => $this->user->adminfirm['state_code'],
            "admin_pincode" => $this->user->adminfirm['pincode'],
            "admin_mobile_number" => $this->user->adminfirm['mobile_number'],
            "admin_landline_number" => $this->user->adminfirm['landline_number'],
            "admin_bank_name" => $this->user->adminfirm['bank_name'],
            "admin_branch_name" => $this->user->adminfirm['branch_name'],
            "admin_ifsc_code" => $this->user->adminfirm['ifsc_code'],
            "admin_account_no" => $this->user->adminfirm['account_no'],

            "firm_id" => $this->firm_id,
            "firm_name" => $this->firm['name'],
            "customer_name" => $this->firm['person_name'],
            "customer_gst" => $this->firm['gst_number'],
            "customer_email" => $this->firm['email'],
            "shipping_address" => $this->firm['shipping_address'],
            "shipping_city" => $this->firm['shipping_city'],
            "shipping_state_code" => $this->firm['shipping_state_code'],
            "shipping_state" => $this->firm->shippingState['state_name'],
            "shipping_pincode" => $this->firm['shipping_pincode'],
            "shipping_mobile_number" => $this->firm['shipping_mobile_number'],
            "shipping_landline_number" => $this->firm['shipping_landline_number'],
            "shipping_landline_number" => $this->firm['shipping_landline_number'],
                
            "billing_address" => $this->firm['billing_address'],
            "billing_city" => $this->firm['billing_city'],
            "billing_state" => $this->firm->billingState['state_name'],
            "billing_state_code" => $this->firm['billing_state_code'],
            "billing_pincode" => $this->firm['billing_pincode'],
            "billing_mobile_number" => $this->firm['billing_mobile_number'],
            "billing_landline_number" => $this->firm['billing_landline_number'],
            "billing_landline_number" => $this->firm['billing_landline_number'],
            
            "invoice_id" => $this->id,
            "invoice_no" => $this->invoice_no,
            "invoiceYear" => $this->invoiceYear,
            "taxable_amount" => number_format($this->taxable_amount),
            "sgst_percentage" => number_format($this->sgst_percentage,2),
            "sgst_amount" => number_format($this->sgst_amount),
            "cgst_percentage" =>  number_format($this->cgst_percentage,2),
            "cgst_amount" => number_format($this->cgst_amount),
            "igst_percentage" =>  number_format($this->igst_percentage,2),
            "igst_amount" => number_format($this->igst_amount),
            "total_payable_amount" => number_format($this->total_payable_amount),
            "created_at" => $this->created_at,
            "product_detail" => $this->billdetail
        ];
    }
}
