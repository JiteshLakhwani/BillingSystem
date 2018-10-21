<?php
 
namespace App\Repositories;
 
use App\Firm;

use App\Repositories\Interfaces\CommonInterface as commonInterface; 
 
class FirmRepository implements commonInterface
{
  protected $firm;
 
  public function __construct(Firm $firm)
  {
    $this->firm = $firm;
  }
    public function create($attributes)
  {
    return $this->firm->create($attributes);
  }
  
  public function all()
  {
    return $this->firm->all();
  }
 
  public function find($id)
  {
   return $this->firm->find($id);
  }
  
  public function update($id, array $attributes)
  {
  return $this->firm->find($id)->update($attributes);
  }

  public function delete($id)
  {
   return $this->firm->find($id)->delete();
  }
}