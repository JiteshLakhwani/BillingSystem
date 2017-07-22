<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firm_name');
            $table->string('admin_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('security_question')->nullable();
            $table->string('security_answer')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->integer('state_code');
            $table->integer('pin_code',false);
            $table->bigInteger('mobile_number')->nullable();
            $table->bigInteger('landline')->nullable();
            $table->string('gst_number');
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}
