<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RentalRequestExtra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_request_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->comment('universally unique identifier');
            $table->string('name')->comment('name of extra item');
            $table->string('description')->comment('description item');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_request_extras');
    }
}
