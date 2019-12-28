<?php

namespace App\Repositories;

use App\ChallanDetail;
use App\Repositories\Interfaces\ChallanDetailInterface as challanDetailInterface; 

class ChallanDetailRepository implements ChallanDetailInterface{


    protected $challanDetail;

    public function __construct(ChallanDetail $challanDetail){
        $this->challanDetail = $challanDetail;
    }

    public function create($attributes){
        
        return $this->challanDetail->create($attributes);
    }
}