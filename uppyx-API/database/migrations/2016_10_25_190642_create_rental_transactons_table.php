<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalTransactonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->comment('universally unique identifier');
            $table->integer('user_id')->unsigned()->comment('user id from table users. transaction owner.');
            $table->enum('type', ['sum', 'sub', 'held', 'other'])->comment('type of transaction');
            $table->float('amount')->comment('amount of transaction');
            $table->timestamps();
            $table->softDeletes();

            //constraint
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
        Schema::dropIfExists('rental_transactions');
    }
}
