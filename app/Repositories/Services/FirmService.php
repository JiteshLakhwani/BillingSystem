<?php

namespace App\Repositories\Services;

use App\Repositories\FirmRepository;
use Illuminate\Http\Request;
use \Response;

class FirmService
{
    public function __construct(FirmRepository $firm)
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
        
        return $this->firm->create($attributes);
    }
    public function read($id)
    {
        $firm = $this->firm->find($id);

        if($firm->count() == 0 )
            {
                return response()->json(["message" => "No data found"]);
            }
        return response()->json($firm);
    }
    
    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        
        $firm = $this->firm->update($id, $attributes);

        if($firm==1)
        {
            $firm = $this->read($id);        
            return Response::json($firm);
        }
        else
        {
            return response()->json(["message" => "Failed to update record"]);
        }
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
}