<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('valid_from')->comment('valid date');
            $table->dateTime('valid_to')->comment('valid to');
            $table->integer('days_from')->comment('days from');
            $table->integer('days_to')->comment('days to');
            $table->float('amount')->comment('price');
            $table->integer('country_id')->unsigned()->comment('country id');
            $table->integer('city_id')->unsigned()->nullable()->comment('city id');
            $table->integer('car_classification_id')->unsigned()->comment('car id');
            $table->timestamps();
            $table->softDeletes();

            //constraint
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('car_classification_id')->references('id')->on('car_classifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
