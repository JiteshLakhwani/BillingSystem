<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('customer_id');
            $table->string('customer_name');
            $table->string('firm_name');
            $table->string('email')->unique()->nullable();
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->integer('shipping_state_code');
            $table->integer('shipping_pin_code');
            $table->bigInteger('shipping_mobile_number')->nullable();
            $table->bigInteger('shipping_landline')->nullable();
            $table->string('billing_address');
            $table->string('billing_city');
            $table->string('billing_state');
            $table->integer('billing_state_code');
            $table->integer('billing_pin_code');
            $table->bigInteger('billing_mobile_number')->nullable();
            $table->bigInteger('billing_landline')->nullable();
            $table->bigInteger('gst_number')->unique();
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
        Schema::dropIfExists('customers');
    }
}
