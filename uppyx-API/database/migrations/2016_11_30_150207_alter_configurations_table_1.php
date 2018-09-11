<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigurationsTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            if(!Schema::hasColumn('configurations','country_id')){
                $table->integer('country_id')->after('value')->unsigned()->comment('country id');

                //constraint
                $table->foreign('country_id')->references('id')->on('countries');
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
            if(Schema::hasColumn('configurations','country_id')){
                $table->dropForeign('configurations_country_id_foreign');
                $table->dropColumn('country_id');
            }
        });
    }
}
