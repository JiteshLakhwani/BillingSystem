<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function billDetails()
    {
        return $this->hasMany(BillDetail::class);
    }
}
