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
            $table->string('invoice_no')->nullable();
            $table->integer('firm_id',false);
            $table->integer('user_id',false);          
            $table->double('taxable_amount',15)->default(0);
            $table->float('sgst_percentage')->default(0);
            $table->float('sgst_amount')->default(0);
            $table->float('cgst_percentage')->default(0);
            $table->float('cgst_amount')->default(0);
            $table->float('igst_percentage')->default(0);
            $table->float('igst_amount')->default(0);
            $table->double('total_payable_amount',15,2)->default(0);
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
