<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigurationsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            if(!Schema::hasColumn('configurations','city_id')){
                $table->integer('city_id')->after('country_id')->unsigned()->nullable()->default(null)->comment('city id');
                //constraint
                $table->foreign('city_id')->references('id')->on('cities');
            }
            if(!Schema::hasColumn('configurations','type')){
                $table->string('type')->after('city_id')->comment('config type. delay, tax');
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
        Schema::table('configurations', function (Blueprint $table) {
            if(Schema::hasColumn('configurations','city_id')){
                $table->dropForeign('configurations_city_id_foreign');
                $table->dropColumn('city_id');
            }
            if(Schema::hasColumn('configurations','type')){
                $table->dropColumn('type');
            }

        });
    }
}
