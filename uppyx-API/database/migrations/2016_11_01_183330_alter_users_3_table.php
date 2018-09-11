<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsers3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('rental_agency_id')->after('license_picture')->unsigned()->nullable()->comment('rental agency where user belong');

            //constraint
            $table->foreign('rental_agency_id')->references('id')->on('rental_agencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_rental_agency_id_foreign');
            $table->dropColumn('rental_agency_id');
        });
    }
}
