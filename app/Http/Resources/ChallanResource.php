<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ChallanResource extends Resource
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
            "challan_no" => $this->challan_no,
            "challanYear" => $this->challanYear,
            "total_payable_amount" => $this->total_payable_amount,
            "created_at" => $this->created_at,
            "product_detail" => $this->challandetail
        ];
    }
}
