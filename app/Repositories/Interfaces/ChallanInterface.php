<?php

namespace App\Repositories\Interfaces;

interface ChallanInterface{

    public function all();

    public function find($id);

    public function create($attributes);

    public function update($id, $attributes);

    public function delete($id);
}