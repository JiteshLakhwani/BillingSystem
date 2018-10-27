<?php
namespace App\Repositories\Interfaces;

interface BillDetailInterface{

    public function all();

    public function find($id);

    public function create ($attrbiutes);

    public function update($id, array $attributes);

    public function delete($id);
}