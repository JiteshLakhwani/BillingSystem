<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BillResource extends Resource
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
                "id" => $this->id,
                "user_id" => $this->user_id,
                "username" => $this->user['name'],
                "firm_id" => $this->firm_id,
                "firm_name" => $this->firm['name'],
                "invoice_no" => $this->invoice_no,
                "invoiceYear" => $this->invoiceYear,
                "gstNumber" => $this->firm['gst_number'],
                "taxable_amount" => $this->taxable_amount,
                "sgst_percentage" => $this->sgst_percentage,
                "sgst_amount" => $this->sgst_amount,
                "cgst_percentage" => $this->cgst_percentage,
                "cgst_amount" => $this->cgst_amount,
                "igst_percentage" => $this->igst_percentage,
                "igst_amount" => $this->igst_amount,
                "total_payable_amount" => $this->total_payable_amount,
                "created_at" => $this->created_at,
                "billdetail" => $this->billdetail
        ];
    }
}
