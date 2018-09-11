<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('User Id. User who is uploading photo');
            $table->integer('rental_request_id')->unsigned()->comment('user id from table users');
            $table->integer('photo')->comment('car photo');
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
        Schema::dropIfExists('rental_inspections');
    }
}
