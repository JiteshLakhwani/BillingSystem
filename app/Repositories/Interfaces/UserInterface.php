<?php
namespace App\Repositories\Interfaces;

interface UserInterface{

    public function create($attributes);
        
    public function update($id, array $attributes);

    public function delete($id);

    public function updatePassword(array $attributes);

    public function find($id);
}