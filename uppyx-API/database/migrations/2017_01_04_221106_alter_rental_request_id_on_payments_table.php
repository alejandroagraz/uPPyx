<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRentalRequestIdOnPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_rental_request_id_foreign');
            $table->dropColumn('rental_request_id');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedInteger('rental_request_id')->after('user_id')->nullable()->comment('Rental Request ID. from table rental_requests');
            $table->foreign('rental_request_id')->references('id')->on('rental_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_rental_request_id_foreign');
            $table->dropColumn('rental_request_id');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedInteger('rental_request_id')->after('user_id')->nullable()->comment('Rental Request ID. from table rental_requests');
            $table->foreign('rental_request_id')->references('id')->on('users');
        });
    }
}
