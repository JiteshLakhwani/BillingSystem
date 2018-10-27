<?php
namespace App\Repositories\Interfaces;

interface StateInterface{

    public function all();

    public function find($id);

    public function create($attributes);

    public function update($id, array $attributes);

    public function delete($id);
}
