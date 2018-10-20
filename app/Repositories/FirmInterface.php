<?php
namespace App\Repositories;

interface FirmInterFace{

    public function create($attributes);
    
    public function all();
   
    public function find($id);
    
    public function update($id, array $attributes);

    public function delete($id);
}