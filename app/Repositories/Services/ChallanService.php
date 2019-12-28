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

        $allChallans = $this->challan->all();

        if(count($allChallans) == 0)
        {
            return response()->json("",204);
        }

        foreach($allChallans as $challan){

            $challans[$i] = new ChallanResource($challan);
            $i +=1;
        }

        return response()->json($challans,200);
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