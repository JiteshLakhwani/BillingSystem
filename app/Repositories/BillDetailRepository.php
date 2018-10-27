<?php

namespace App\Repositories;

use App\BillDetail;
use App\Repositories\Interfaces\BillDetailInterface as billDetailInterface; 

class BillDetailRepository implements billDetailInterface{

    protected $billDetail;

    public function __construct(BillDetail $billDetail){
        $this->billDetail = $billDetail;
    }

    public function create($attributes){
        
        return $this->billDetail->create($attributes);
    }

    public function all(){
        return $this->billDetail->all();
    }

    public function find($id){

        return $this->billDetail->find($id);
    }

    public function update($id, array $attribute){
        
        return $this->billDetail->find($id)->update($attribute);
    }

    public function delete($id){

        return $this->billDetail->find($id)->delete();
    }    
}