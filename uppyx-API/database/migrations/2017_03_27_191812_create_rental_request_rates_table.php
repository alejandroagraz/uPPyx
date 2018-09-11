<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalRequestRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_request_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->comment('universally unique identifier');
            $table->unsignedInteger('user_id')->comment('user id from table users. user who is making the rate');
            $table->unsignedInteger('rental_request_id')->comment('rental request id');
            $table->integer('rate')->comment('rental request id');
            $table->text('comment')->comment('comment of request rate');

            $table->timestamps();
            $table->softDeletes();

            //constraint
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('rental_request_id')->references('id')->on('rental_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_request_rates');
    }
}
