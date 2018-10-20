<?php

namespace App\Repositories\Services;

use App\Firm;
use App\Repositories\FirmRepository;
use Illuminate\Http\Request;

class FirmService
{
    public function __construct(FirmRepository $firm)
    {
        $this->firm = $firm;
    }
    
    public function index()
    {
        return $this->firm->all();
    }
    
    public function create(Request $request)
    {
        $attributes = $request->all();
        
        $firm = $this->firm->create($attributes);

        return $this->read($firm['id']);
    }
    public function read($id)
    {
        return $this->firm->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        
        return $this->firm->update($id, $attributes);

    
    }
    
    public function delete($id)
    {
        return $this->firm->delete($id);
    }
}