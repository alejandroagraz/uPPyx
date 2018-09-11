<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChargeTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charges', function (Blueprint $table) {
            if(Schema::hasColumn('charges','country_id'))
            {
                $table->dropForeign('charges_country_id_foreign');
                $table->dropColumn('country_id');
            }
            if(Schema::hasColumn('charges','city_id'))
            {
                $table->dropForeign('charges_city_id_foreign');
                $table->dropColumn('city_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charges', function (Blueprint $table) {
            if(!Schema::hasColumn('charges','country_id'))
            {
                $table->unsignedInteger('country_id')->nullable()->comment('country id');

                //constraint
                $table->foreign('country_id')->references('id')->on('countries');
            }
            if(!Schema::hasColumn('charges','city_id'))
            {
                $table->unsignedInteger('city_id')->nullable()->after('country_id')->comment('city id');

                //constraint
                $table->foreign('city_id')->references('id')->on('cities');
            }
        });
    }
}
