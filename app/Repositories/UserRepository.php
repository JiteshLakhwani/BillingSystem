<?php
namespace App\Repositories;

use App\Repositories\Interfaces\UserInterface as userInterface;
use App\User;

class UserRepository implements userInterface{

    protected $user;

    public function __construct(User $user){
        
        $this->user = $user;
    }

    public function update($id, array $attributes){

        return $this->user->find($id)->update($attributes);
    }

    public function create($attributes){

        return $this->user->create($attributes);
    }
        
    public function delete($id){

        return $this->user->find($id)->delete();
    }

    public function updatePassword(array $attributes){
        
        return $this->user->updatePassword($attributes);
    }

    public function find($id)
  {
      
      return $this->user->find($id);
  }

}