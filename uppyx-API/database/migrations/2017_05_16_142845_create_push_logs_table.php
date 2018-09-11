<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->comment('universally unique identifier');
            $table->string('message', 255)->comment('push message error log');
            $table->text('context')->comment('push context error log');
            $table->enum('level', ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
                ->default('info')->comment('level push error log');
            $table->unsignedInteger('user_id')->comment('user id');
            $table->unsignedInteger('rental_request_id')->nullable()->comment('rental request id');
            $table->string('token_device')->comment('user token device');
            $table->enum('status', ['sent', 'failed'])->comment('push status');
            $table->tinyInteger('attempts')->unsigned()->comment('push attempts');
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
        Schema::dropIfExists('push_logs');
    }
}
