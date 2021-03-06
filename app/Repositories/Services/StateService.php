<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\StateInterface;
use App\Http\Resources\StateResource;

class StateService{

    protected $stateInterface;

    public function __construct(StateInterface $stateInterface) {

        $this->stateInterface = $stateInterface;
    }

    public function getAll() {

        $allStates = $this->stateInterface->all();

        if(count($allStates) == 0){

            return response()->json("",204);
        }

        return response()->json($allStates,200);
    }

    public function create($request) {

        $attrbiutes = $request->all();
        return new StateResource($this->stateInterface->create($attrbiutes));
    }

    public function update($id, $request){

        $attrbiutes = $request->all();

        if($this->stateInterface->update($id, $attrbiutes) == true){

            return new StateResource ($this->stateInterface->find($id));
        }
    }

    public function delete($id){

        if($this->stateInterface->find($id) == null){

            return response()->json(["error"=>"Couldn't find record"]);
         }

        $this->stateInterface->delete($id);

         if($this->stateInterface->find($id) == null){

            return response()->json(["message"=>"Record deleted successfuly"]);
         }
         return response()->json(["error"=>"Couldn't delete record"]);
    }
}