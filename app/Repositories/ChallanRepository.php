<?php

namespace App\Repositories;

use App\Challan;
use App\Repositories\Interfaces\ChallanInterface as challanInterface;

class ChallanRepository implements challanInterface{

    protected $challan;

    public function __construct (Challan $challan){

        return $this->challan = $challan;
    }

    public function all(){

        return $this->challan->orderBy('challan_no','desc')->get();
    }

    public function find($id){

        return $this->challan->find($id);
    }

    public function create($attributes){

        return $this->challan->create($attributes);
    }

    public function update($id, $attributes){

        return $this->challan->find($id)->update($attributes);
    }

    public function delete($id){

        $this->challan->find($id)->delete();
    }

}