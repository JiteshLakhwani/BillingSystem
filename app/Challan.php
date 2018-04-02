<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challan extends Model
{
    protected $fillable = ['firm_id', 'user_id', 'challan_no','created_at',
    'total_payable_amount', 'challanYear'];
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
        return $this->hasMany(ChallanDetail::class);
    }
}
