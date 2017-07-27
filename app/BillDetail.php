<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $fillable = ['product_id', 'quantity', 'bill_id'];
    public $table="billdetails";

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
