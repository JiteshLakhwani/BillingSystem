<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Response;
use App\State;
use \Validator;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                
                return response()->json(['error' => 'Token Not Available'], 400);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'Token Expired'], 500);
        }

        $states = state::get();
        if($states->count() == 0 )
        {
            return response()->json(["error" => "No data in table"]);
        }
        foreach($states as $state)
        {
            $response ['states'][]= ['state_code' =>$state->state_code,
                         'state_name' =>$state->state_name
            ];
        }
        return response()->json($response,200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
               $this->verifyToken();

        $validator = Validator::make($request->all(), [

            "state_code"=> 'required|integer|unique:states',
            "state_name"=> 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }
$state = State::create([
                "state_code" => $request->state_code,
                "state_name" => $request->state_name
        ]);

        return response()->json(["state_code"=>$state->state_code,
                                "state_name"=>$state->state_name]);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->verifyToken();

        $validator = Validator::make($request->all(), [

            "state_code"=> 'required',
            "state_name"=> 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }
            $state = State::where("state_code", $id)->update([
                "state_code" => $request->state_code,
                "state_name" => $request->state_name
        ]);

        if($state==1)
        {
            $updatedState = State::find($id);
            return response()->json(["state_code"=>$updatedState->state_code,
                                "state_name"=>$updatedState->state_name]);
    }
        }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        State::destroy($id);
        $state=State::find($id);
        if($state==null)
        {
            return response()->json(["message"=>"Record deleted"]);
        }
    }

    public function verifyToken()
    {
            try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                
                return response()->json(['error' => 'Token Not Available'], 400);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'Token Expired'], 500);
        }

    }
}
