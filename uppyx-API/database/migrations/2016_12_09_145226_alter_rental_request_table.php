<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRentalRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->integer('taken_by_manager')->after('taken_by_user')->unsigned()->nullable()->comment('user id from table users. user who took the request');

            //constraint
            $table->foreign('taken_by_manager')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->dropForeign('rental_requests_taken_by_manager_foreign');
            $table->dropColumn('taken_by_manager');
        });
    }
}
