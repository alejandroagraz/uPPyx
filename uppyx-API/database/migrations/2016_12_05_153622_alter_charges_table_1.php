<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChargesTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->integer('configuration_id')->unsigned()->after('car_classification_id')->comment('type charge');

            //constraint
            $table->foreign('configuration_id')->references('id')->on('configurations');
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
            $table->dropForeign('charges_configuration_id_foreign');
            $table->dropColumn('configuration_id');
        });
    }
}
