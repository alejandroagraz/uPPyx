<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalAgencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_agencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',50)->comment('universally unique identifier');
            $table->unsignedInteger('user_id')->nullable()->comment('registered by');
            $table->string('name')->comment('agency name');
            $table->string('address')->comment('agency address');
            $table->string('phone')->comment('agency phone');
            $table->text('description')->comment('agency description');
            $table->boolean('status')->default('1')->comment('agency status. 1=active, 2=disable');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('rental_agencies');
    }
}
