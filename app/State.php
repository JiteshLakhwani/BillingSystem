<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable   = ['state_code','state_name'];
    protected $primaryKey = 'state_code';
    public $incrementing  = false;
   
    public function billingFirm()
    {
    return $this->hasMany(Firm::class, 'billing_state_code', 'state_code');
    }

    public function shippingFirm()
    {
    return $this->hasMany(Firm::class, 'shipping_state_code', 'state_code');
    }

    public function adminfirm()
    {
    return $this->hasMany(AdminFirm::class, 'state_code', 'state_code');
    }
}
