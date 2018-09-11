<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteRequestAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_agencies', function (Blueprint $table) {
            Schema::dropIfExists('request_agencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_agencies', function (Blueprint $table) {
            Schema::create('request_agencies', function (Blueprint $table) {
                $table->increments('id');
                $table->string('uuid',50)->comment('universally unique identifier');
                $table->integer('user_id')->unsigned()->comment('user id from table users. user who take the request');
                $table->integer('rental_request_id')->unsigned()->comment('rental request id');
                $table->timestamps();
                $table->softDeletes();

                //constraint
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('rental_request_id')->references('id')->on('rental_requests');
            });

        });
    }
}
