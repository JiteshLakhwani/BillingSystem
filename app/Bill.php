<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['firm_id', 'user_id', 'sgst_percentage', 'invoice_no','created_at',
    'sgst_amount','cgst_precentage', 'cgst_amount','igst_percentage', 'igst_amount','taxable_amount',
    'total_payable_amount'];
    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function billdetail()
    {
        return $this->hasMany(BillDetail::class);
    }

    public function delete()
    {

        $this->billdetail()->delete();

        // delete the bill
        return parent::delete();
    }
}
