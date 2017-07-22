<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminFirm extends Model
{
    public $table="adminfirms";
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
