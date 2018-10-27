<?php
namespace App\Repositories\Interfaces;

interface AdminFirmInterface{

    public function update($id, array $attributes);

    public function find($id);
}