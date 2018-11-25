<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\BillInterface;
use App\Repositories\Interfaces\FirmInterface;
use App\Http\Resources\BillResource;
use App\Http\Resources\FirmReportResource;
use App\Http\Resources\BillReportResource;

class ReportService {

    protected $billInterface;

    protected $firmInterface;

    public function __construct (BillInterface $billInterface, FirmInterface $firmInterface) {

        $this->billInterface = $billInterface;

        $this->firmInterface = $firmInterface;
    }

    public function reportBetweenTwoDates($request){

        $first_date = date('Y-m-d',strtotime($request->start_date));
        $last_date = date('Y-m-d',strtotime($request->end_date));
        $allBills = $this->billInterface->getBetweenTwoDates($first_date, $last_date);
        
        if(count($allBills) == 0)
        {
            return response()->json("",204);
        }

        foreach($allBills as $bill){

            $bills[$i] = new BillResource($bill[$i]);
        }

        return $bills;
    }

    public function reportFiscalYear($year){

        $allBills = $this->billInterface->getFiscalYearReport($year);
        
        if(count($allBills) == 0)
        {
            return response()->json("",204);
        }

        foreach($allBills as $bill){

            $bills[$i] = new BillResource($bill[$i]);
        }

        return $bills;
    }

    public function reportByFirmName($firmName) {

        $firm = $this->firmInterface->getReportByFirmName($firmName);

        if(count($firm) == 0) {
            
            return response()->json("",204);
        }
        
        return new FirmReportResource($firm[0]);
    }

    public function reportByInvoiceNumber($invoiceNumber, $invoiceYear){

        $bill = $this->billInterface->getReportByInvoiceNumber($invoiceNumber, $invoiceYear);

        if(count($bill) == 0) {
            
            return response()->json("",204);
        }

        return new BillReportResource($bill[0]);
    }
}