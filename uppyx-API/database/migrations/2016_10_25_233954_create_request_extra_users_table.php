<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestExtraUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_extra_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('user id from table users');
            $table->integer('request_extra_id')->unsigned()->comment('user id from table users');
            $table->timestamps();
            $table->softDeletes();

            //constraint
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('request_extra_id')->references('id')->on('rental_request_extras');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_extra_users');
    }
}
