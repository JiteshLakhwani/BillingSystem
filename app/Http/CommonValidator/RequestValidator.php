<?php

namespace App\Http\CommonValidator;

use \Validator;

class RequestValidator {
 
    public function validateRequest($request, array $validationFields) {

        $validator = Validator::make($request->all(), $validationFields);
        
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }
        
        return "validatePass";
    }
}