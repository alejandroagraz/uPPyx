<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRentalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->integer('car_classification_id')->unsigned()->after('dropoff_date')->comment('car classification');
            $table->dropColumn('status');
            //constraint
            $table->foreign('car_classification_id')->references('id')->on('car_classifications');
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
            $table->dropForeign('rental_requests_car_classification_id_foreign');
            $table->dropColumn('car_classification_id');
            $table->enum('status', ['sent','cancelled','taken','finished'])->after('dropoff_date')->comment('request status. sent, cancelled, taken, finished');
        });
    }
}
