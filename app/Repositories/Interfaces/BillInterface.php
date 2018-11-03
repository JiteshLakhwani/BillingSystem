<?php

namespace App\Repositories\Interfaces;

interface BillInterface{

    public function all();

    public function find($id);

    public function create($attributes);

    public function update($id, array $attributes);

    public function delete($id);

    public function getSortBill();

    public function getBetweenTwoDates($startDate, $endDate);

    public function getFiscalYearReport($year);

    public function getReportByInvoiceNumber($invoiceNumber, $invoiceYear);
}