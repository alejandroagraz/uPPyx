<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_city_id_foreign');
            $table->dropColumn('city_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('country', 255)->nullable()->after('license_picture')->comment('user country');
            $table->string('city', 255)->nullable()->after('country')->comment('user city');
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
            $table->unsignedInteger('city_id')->nullable()->after('license_picture')->comment("user city");
            $table->foreign('city_id')->references('id')->on('cities');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('city');
        });
    }
}
