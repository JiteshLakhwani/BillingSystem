<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['firm_id', 'user_id', 'sgst_percentage', 
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
        // delete all related photos 
        $this->billdetail()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }
}
