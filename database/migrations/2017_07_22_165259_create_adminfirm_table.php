<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminfirmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adminfirms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('person_name');
            $table->string('gst_number')->unique();
            $table->string('billing_address');
            $table->string('billing_city_name');
            $table->string('billing_state_name');
            $table->integer('billing_state_code');
            $table->integer('billing_pincode');
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
        Schema::dropIfExists('adminfirms');
    }
}
