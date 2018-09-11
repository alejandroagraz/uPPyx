<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestLicenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_licenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('license_name');
            $table->integer('user_id')->unsigned()->comment('user id from table users.');
            $table->integer('rental_request_id')->unsigned()->nullable()->comment('rental request id.');
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
        Schema::dropIfExists('request_licenses');
    }
}
