<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalRequestExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_request_extensions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->comment('universally unique identifier');
            $table->unsignedInteger('user_id')->comment('registered by');
            $table->unsignedInteger('rental_request_id')->comment('rental request id');
            $table->integer('total_days')->comment('number of days of rental extension');
            $table->float('total_cost')->comment('total cost of rental extension');
            $table->string('dropoff_address')->comment('drop off address of rental extension');
            $table->dateTime('dropoff_date')->comment('drop off date of rental extension');
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
        Schema::dropIfExists('rental_request_extensions');
    }
}
