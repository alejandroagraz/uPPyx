<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RentalRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->comment('universally unique identifier');
            $table->integer('user_id')->unsigned()->comment('user id from table users. user who made the request');
            $table->integer('taken_by_user')->unsigned()->comment('User Id from users');
            $table->integer('taken_by_agency')->unsigned()->comment('Rental Agency Id. from rental_agencies.');
            $table->integer('total_days')->comment('number of days');
            $table->float('total_cost')->comment('total cost of rental');
            //pick up
            $table->string('pickup_address')->comment('pick up address');
            $table->dateTime('pickup_date')->comment('pick up date');
            //drop off
            $table->string('dropoff_address')->comment('drop off address');
            $table->dateTime('dropoff_date')->comment('drop off date');
            $table->enum('status', ['sent','cancelled','taken','finished'])->comment('request status. sent, cancelled, taken, finished');
            $table->enum('type', ['standard','planned'])->comment('type of request');

            $table->timestamps();
            $table->softDeletes();
            //constraint
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('taken_by_user')->references('id')->on('users');
            $table->foreign('taken_by_agency')->references('id')->on('rental_agencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_requests');
    }
}
