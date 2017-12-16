<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminFirm extends Model
{

   protected $fillable = [
        'name', 'person_name', 'gst_number','billing_address','billing_city_name',
        'billing_state_name','billing_state_code','billing_pincode','billing_mobile_number'
        ,'billing_landline_number', 'email', 'bank_name','ifsc_code','account_no','branch_name'
    ];

    public $table="adminfirms";
    
    public function user()
    {
        return $this->hasMany(User::class);
    }
     public function state()
{
    return $this->belongsTo(State::class, 'state_code', 'state_code');
}
}
