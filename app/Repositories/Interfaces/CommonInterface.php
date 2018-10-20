<?php
namespace App\Repositories\Interfaces;

interface CommonInterface{

    public function create($attributes);
    
    public function all();
   
    public function find($id);
    
    public function update($id, array $attributes);

    public function delete($id);
}