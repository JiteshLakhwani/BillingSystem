<?php

namespace App\Repositories;

use App\Bill;
use App\Repositories\Interfaces\BillInterface as billInterface; 

class BillRepository implements billInterface{

    protected $bill;

    public function __construct(Bill $bill){
        $this->bill = $bill;
    }

    public function create($attributes){

        return $this->bill->create($attributes);
    }

    public function all(){
        return $this->bill->all();
    }

    public function find($id){

        return $this->bill->find($id);
    }

    public function update($id, array $attribute){
        
        return $this->bill->find($id)->update($attribute);
    }

    public function delete($id){

        $this->bill->find($id)->delete();
    }

    public function getSortBill()
    {

        return $this->bill->orderBy('invoice_no','desc')->get();
    }
}