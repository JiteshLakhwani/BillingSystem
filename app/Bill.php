<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
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
}
