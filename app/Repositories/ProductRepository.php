<?php
namespace App\Repositories;

use App\Product;
use App\Repositories\Interfaces\ProductInterface as productInterface;


class ProductRepository implements productInterface{

    protected $product;

    public function __construct (Product $product){

        return $this->product = $product;
    } 

    public function all() {

        return $this->product->all();
    }

    public function find($id){
        
        return $this->product->find($id);
    }

    public function create($attributes){

        return $this->product->create($attributes);
    }

    public function update($id, array $attributes){

        return $this->product->find($id)->update($attributes);
    }

    public function delete($id){

        $this->product->find($id)->delete();
    }
}