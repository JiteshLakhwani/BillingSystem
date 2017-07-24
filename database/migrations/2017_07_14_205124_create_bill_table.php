<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no');
            $table->integer('firm_id',false);
            $table->integer('user_id',false);          
            $table->float('discount_percentage');
            $table->float('discount_amount');
            $table->double('taxable_amount');
            $table->float('sgst_percentage');
            $table->float('sgst_amount');
            $table->float('cgst_precentage');
            $table->float('cgst_amount');
            $table->float('igst_percentage');
            $table->float('igst_amount');
            $table->double('total_payable_amount',15,8);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
