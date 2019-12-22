<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\FirmInterface;
use Illuminate\Http\Request;
use \Response;
use App\Http\Resources\FirmResource;

class FirmService
{
    public function __construct(FirmInterface $firm)
    {
        $this->firm = $firm;
    }
    
    public function index()
    {
        $firms = $this->firm->all();

        if($firms->count() == 0 )
        {
            return response()->json("",204);
        }
        return response()->json($firms,200);
    }
    
    public function create(Request $request)
    {
        $attributes = $request->all();
        
        $firm = $this->firm->create($attributes);

        if($firm == null){

            return response()->json(["message" => "Failed to update record"]);
        }

        return new FirmResource($firm);

    }
    public function read($id)
    {
        $firm = $this->firm->find($id);

        if($firm == null)
            {
                return response()->json("",204);
            }
        return new FirmResource($firm);
    }
    
    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        
        $firm = $this->firm->update($id, $attributes);

        if($firm != null)
        {
            $firm = $this->read($id);        
            
            return response()->json($firm, 200);
        }
        return response()->json(["message" => "Failed to update record"]);
    }
    
    public function delete($id)
    {
        $firm = $this->read($id);
        if($firm == null)
        {
            return response()->json("",204);
        }

        $this->firm->delete($id);

        $firm = $this->read($id);
            if($firm==null)
            {
                return response()->json(["message"=>"Record deleted successfuly"], 200);
            }
    }
}