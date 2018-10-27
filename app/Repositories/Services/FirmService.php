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
            return response()->json(["message" => "No data found"]);
        }
        return response()->json(["Firms"=>$firms],200);
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

        if($firm->count() == 0 )
            {
                return response()->json(["message" => "No data found"]);
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
            return new FirmResource($firm);
        }
        return response()->json(["message" => "Failed to update record"]);
    }
    
    public function delete($id)
    {
        $firm = $this->read($id);
        if($firm == null)
        {
            return response()->json(["error"=>"Couldn't find record"]);
        }

        $this->firm->delete($id);

        $firm = $this->read($id);
            if($firm==null)
            {
                return response()->json(["message"=>"Record deleted successfuly"]);
            }
    }

    public function listCustomer()
    {        
        if($this->firm->all()->count() == 0){
            return response()->json(["message" => "No Customer"]);
        }
        $firms = $this->firm->all();
        foreach($firms as $firm)
            {
                $response ['firms'][]= ['id' => $firm->id,
                'firm_name' =>$firm->name,
                'state_code'=>$firm->billing_state_code
                ];
            }
        return response()->json($response,200);
    }
}