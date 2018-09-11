<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->comment('universally unique identifier');
            $table->integer('log_type_id')->unsigned()->comment('log type id');
            $table->integer('user_id')->unsigned()->comment('user id from table users. user who is making this log');
            $table->integer('rental_agencies_id')->unsigned()->nullable()->comment('rental agency id');
            $table->text('message')->comment('rental agency id');

            $table->timestamps();
            $table->softDeletes();

            //constraint
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('rental_agencies_id')->references('id')->on('rental_agencies');
            $table->foreign('log_type_id')->references('id')->on('log_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
