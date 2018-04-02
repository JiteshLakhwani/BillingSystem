<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallanDetail extends Model
{
    protected $fillable = ['product_id', 'quantity', 'challan_id','price','discount_percentage', 'discount_amount'
    ,'size'];
    public $table="challandetails";

    public function challan()
    {
        return $this->belongsTo(Challan::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
