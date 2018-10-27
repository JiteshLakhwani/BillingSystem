<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AdminFirmInterface as adminFirmInterface;
use App\AdminFirm;

class AdminFirmRepository implements adminFirmInterface{

    protected $adminFirm;

    public function __construct(AdminFirm $adminFirm){
        
        $this->adminFirm = $adminFirm;
    }

    public function update($id, array $attributes){

        return $this->adminFirm->find($id)->update($attributes);
    }

    public function find($id){

        return $this->adminFirm->find($id);
    }
}