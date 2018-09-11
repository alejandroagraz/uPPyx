<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBoundsCountriesTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bounds_countries', function (Blueprint $table) {
            if(Schema::hasColumn('bounds_countries','country_id'))
            {
                $table->dropForeign('bounds_countries_country_id_foreign');
                $table->dropColumn('country_id');
            }

            $table->unsignedInteger('city_id')->comment('city id');

            //constraints
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bounds_countries', function (Blueprint $table) {
            if(!Schema::hasColumn('bounds_countries','country_id'))
            {
                $table->unsignedInteger('country_id')->nullable()->comment('country id');

                //constraints
                $table->foreign('country_id')->references('id')->on('countries');
            }

            if(Schema::hasColumn('bounds_countries','country_id'))
            {
                $table->dropForeign('bounds_countries_city_id_foreign');
                $table->dropColumn('city_id');
            }
        });
    }
}
