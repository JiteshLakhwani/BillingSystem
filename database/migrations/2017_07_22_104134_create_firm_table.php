<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('person_name');
            $table->string('gst_number')->unique()->nullable();
            $table->string('email')->nullable();
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->integer('shipping_state_code');
            $table->integer('shipping_pincode')->nullable();
            $table->bigInteger('shipping_mobile_number')->nullable();
            $table->bigInteger('shipping_landline_number')->nullable();
            $table->string('billing_address');
            $table->string('billing_city');
            $table->integer('billing_state_code');
            $table->integer('billing_pincode')->nullable();
            $table->bigInteger('billing_mobile_number')->nullable();
            $table->bigInteger('billing_landline_number')->nullable();
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
        Schema::dropIfExists('firms');
    }
}
