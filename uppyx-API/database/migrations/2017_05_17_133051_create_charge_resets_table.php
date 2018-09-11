<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargeResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_resets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rental_request_id')->unique()->comment('rental request id');
            $table->timestamps();

            //constraint
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
        Schema::dropIfExists('charge_resets');
    }
}
