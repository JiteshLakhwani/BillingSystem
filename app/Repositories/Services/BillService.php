<?php

namespace App\Repositories\Services;

use Illuminate\Http\Request;
use App\Repositories\BillRepository;
use App\Repositories\BillDetailRepository;

class BillService {
    protected $bill;

    protected $billDetail;

    public function __construct(BillRepository $bill, BillDetailRepository $billDetail){

        $this->bill = $bill;

        $this->billDetail = $billDetail;
    }

    public function create(Request $request){

        $attribute = $request->all();
        
        $bill = $this->bill->create($attribute);

        $billDetailAttributes = $request->bill_detail;

        for ($i = 0; $i < count($billDetailAttributes); $i++) {

            $billDetailAttributes[$i]['bill_id'] = $bill['id'];

            $billDetails[$i] = $this->billDetail->create($billDetailAttributes[$i]);
        }
        
        $returnBillAndDetails[0] = $bill;

        $returnBillAndDetails[1] = $billDetails;

        return $returnArray;
    }

    public function index(){

        return $this->bill->all();
    }

    public function update(Request $request, $id){

        $attribute = $request->all();

        return $this->bill->update($id, $attribute);
    }

    public function delete($id){

        $bill = $this->read($id);
        if($bill == null)
            {
                return response()->json(["error"=>"Couldn't find record"]);
            }

        $this->bill->delete($id);

        $bill = $this->read($id);
        if($bill==null)
        {
            return response()->json(["message"=>"Record deleted successfuly"]);
        }
    }

    public function read($id)
    {
        return $this->bill->find($id);
    }
}

