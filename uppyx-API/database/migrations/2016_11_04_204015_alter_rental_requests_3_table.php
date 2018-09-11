<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRentalRequests3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->string('pickup_address_coordinates')->after('pickup_address')->nullable()->comment('coordinates of pick up address');
            $table->string('dropoff_address_coordinates')->after('dropoff_address')->nullable()->comment('coordinates of drop off address');
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
            $table->dropColumn('pickup_address_coordinates');
            $table->dropColumn('dropoff_address_coordinates');
        });
    }
}
