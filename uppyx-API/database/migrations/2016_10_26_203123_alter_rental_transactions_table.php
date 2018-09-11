<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRentalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_transactions', function (Blueprint $table) {
            $table->integer('rental_request_id')->after('user_id')->unsigned()->comment('rental request id');

            //constraint
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
        Schema::table('rental_transactions', function (Blueprint $table) {
            $table->dropForeign('rental_transactions_rental_request_id_foreign');
            $table->dropColumn('rental_request_id');
        });
    }
}
