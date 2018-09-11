<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokenDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->comment('universally unique identifier');
            $table->string('token', 100)->comment('device token');
            $table->integer('user_id')->unsigned()->comment('foreign key User');
            $table->enum('operative_system',['ios','android'])->comment('client operative system');
            $table->timestamps();
            $table->softDeletes();

            //foreign keys
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('token_devices');
    }
}
