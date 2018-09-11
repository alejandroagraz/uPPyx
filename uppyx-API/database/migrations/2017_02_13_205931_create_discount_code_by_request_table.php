<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCodeByRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for associating roles to users (Many-to-Many)
        Schema::create('discount_code_by_request', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->comment('universally unique identifier');
            $table->unsignedInteger('discount_code_id')->comment('discount code id');
            $table->unsignedInteger('rental_request_id')->comment('rental request id');

            $table->foreign('discount_code_id')->references('id')->on('discount_codes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rental_request_id')->references('id')->on('rental_requests')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_code_by_request');
    }
}
