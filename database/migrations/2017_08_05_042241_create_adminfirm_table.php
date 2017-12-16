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
            $table->string('email')->unique();
            $table->string('address');
            $table->string('cityname');
            $table->integer('state_code');
            $table->integer('pincode');
            $table->bigInteger('mobile_number')->nullable();
            $table->bigInteger('landline_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->bigInteger('account_no')->nullable();
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
