<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['id' => $this->id,
                'product_name' =>$this->product_name,
                'hsn_code' =>$this->hsn_code,
                'product_price'=>$this->product_price
        ];
    }
}
