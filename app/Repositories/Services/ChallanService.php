<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\ChallanInterface;
use App\Repositories\Interfaces\ChallanDetailInterface;
use App\Http\Resources\ChallanResource;
use Illuminate\Http\Request;

class ChallanService {

    protected $challan;
    protected $challanDetail;

    public function __construct(ChallanInterface $challanInterface, ChallanDetailInterface $challanDetailInterface){

        $this->challan = $challanInterface;

        $this->challanDetail = $challanDetailInterface;
    }

    public function getAll(){

        $i = 0;
        $allChallans = array();

        $allChallans = $this->challan->all();

        if(empty($allChallans))
        {
            return response()->json("",204);
        }

        return response()->json($allChallans,200);
    }

    public function store(Request $request){

        $attribute = $request->all();
        
        $challan = $this->challan->create($attribute);

        $challanDetailAttributes = $request->product_detail;

        for ($i = 0; $i < count($challanDetailAttributes); $i++) {

            $challanDetailAttributes[$i]['challan_id'] = $challan['id'];

            // dd($challanDetailAttributes[$i]);

            $this->challanDetail->create($challanDetailAttributes[$i]);
        }
        
        return new ChallanResource($challan);
    }
}