<?php

namespace App\Repositories\Services;
use Illuminate\Cache\Repository as CacheRepository;
use App\Repositories\Interfaces\ProductInterface;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Redis;

class ProductService {

    protected $productInterface;

    protected $cache;

    public function __construct(ProductInterface $productInterface, CacheRepository $cache) {

        $this->productInterface = $productInterface;

        $this->cache = $cache;
    }

    public function getAll() {

        $allProducts = $this->productInterface->all();

        if(count($allProducts) == 0)
        {
            return response()->json("",204);
        }

        return response()->json($allProducts,200);
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

            $this->cache->forget('productList');

            return response()->json(["message"=>"Record deleted successfuly"]);
         }
         return response()->json(["error"=>"Couldn't delete record"]);
    }
}