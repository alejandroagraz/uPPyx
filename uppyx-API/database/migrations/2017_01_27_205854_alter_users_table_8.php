<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->unsignedInteger('country_id')->after('license_picture')->nullable()->comment('user\'s country');
            $table->unsignedInteger('city_id')->nullable()->after('license_picture')->comment("user city");
            $table->enum('gender', ['M', 'F'])->after('city_id')->nullable()->comment("user gender");
            $table->date('birth_of_date')->after('gender')->nullable()->comment("user birth of date");
            $table->enum('default_lang', ['en', 'es'])->after('birth_of_date')->nullable()->comment("user default language");
            //constraint
//            $table->foreign('country_id')->references('id')->on('countries');
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
        Schema::table('users', function (Blueprint $table) {
//            $table->dropForeign('users_country_id_foreign');
            $table->dropForeign('users_city_id_foreign');
//            $table->dropColumn('country_id');
            $table->dropColumn('city_id');
            $table->dropColumn('gender');
            $table->dropColumn('birth_of_date');
            $table->dropColumn('default_lang');
        });
    }
}
