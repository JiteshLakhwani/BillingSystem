<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallandetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challandetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->integer('challan_id');
            $table->integer('product_id');
            $table->float('price')->default(0);
            $table->string('size');
            $table->float('discount_percentage')->nullable()->default(0);
            $table->float('discount_amount')->nullable()->default(0);
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
        Schema::dropIfExists('challandetails');
    }
}
