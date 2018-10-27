<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class StateResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['state_code' =>$this->state_code,
                'state_name' =>$this->state_name
        ];
    }
}
