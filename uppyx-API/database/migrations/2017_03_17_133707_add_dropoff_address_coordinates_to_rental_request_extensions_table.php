<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDropoffAddressCoordinatesToRentalRequestExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_request_extensions', function (Blueprint $table) {
            $table->string('dropoff_address_coordinates')->nullable()->after('dropoff_date')->comment('new drop off address coordinates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rental_request_extensions', function (Blueprint $table) {
            $table->dropColumn('dropoff_address_coordinates');
        });
    }
}
