<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\ProductInterface;
use App\Http\Resources\ProductResource;

class ProductService {

    protected $productInterface;

    public function __construct(ProductInterface $productInterface) {

        $this->productInterface = $productInterface;
    }

    public function getAll() {

        $allProducts = $this->productInterface->all();

        if(count($allProducts) == 0)
        {
            return response()->json("",204);
        }

        foreach($allProducts as $product) {

            $products['products'][] = new ProductResource($product);
        }

        return $products;
    }

    public function create($request) {

        $attrbiutes = $request->all();
        return new ProductResource($this->productInterface->create($attrbiutes));
    }

    public function update($id, $request){

        $attrbiutes = $request->all();

        if($this->productInterface->update($id, $attrbiutes) == true){

            return new ProductResource ($this->productInterface->find($id));
        }
    }

    public function delete($id){


        if($this->productInterface->find($id) == null){

            return response()->json("",204);
         }

        $this->productInterface->delete($id);

         if($this->productInterface->find($id) == null){

            return response()->json(["message"=>"Record deleted successfuly"]);
         }
         return response()->json(["error"=>"Couldn't delete record"]);
    }
}