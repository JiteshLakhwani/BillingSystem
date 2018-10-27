<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FirmResource extends Resource
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
            "name" => $this->name,
            "person_name" =>$this->person_name,
            "gst_number" =>$this->gst_number,
            "email" =>$this->email,
            "billing_address" =>$this->billing_address,
            "billing_state" => $this->billingState,
             
            "billing_city" =>$this->billing_city,
            "billing_pincode" =>$this->billing_pincode,
            "billing_mobile_number" =>$this->billing_mobile_number,
            "billing_mobile_number" =>$this->billing_landline_number,

            "shipping_address" =>$this->shipping_address,
            "shipping_state_name" => $this->shippingState,
            "shipping_city" =>$this->shipping_city,
            "shipping_pincode" =>$this->shipping_pincode,
            "shipping_mobile_number" =>$this->shipping_mobile_number,
            "shipping_mobile_number" =>$this->shipping_landline_number];
    }
}
