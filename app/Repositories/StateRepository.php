<?php
namespace App\Repositories;

use App\State;
use App\Repositories\Interfaces\StateInterface as stateInterface;


class stateRepository implements stateInterface{

    protected $state;

    public function __construct (State $state){

        return $this->state = $state;
    } 

    public function all() {

        return $this->state->all();
    }

    public function find($id){
        
        return $this->state->find($id);
    }

    public function create($attributes){

        return $this->state->create($attributes);
    }

    public function update($id, array $attributes){

        return $this->state->find($id)->update($attributes);
    }

    public function delete($id){

        $this->state->find($id)->delete();
    }
}
