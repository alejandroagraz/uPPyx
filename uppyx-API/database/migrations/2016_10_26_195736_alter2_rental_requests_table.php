<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Alter2RentalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->enum('status', ['sent','cancelled','taken','finished','on-board'])->after('type')->comment('request status. "sent=when user sent request", "cancelled=when user cancel the request". "taken=when agent take the request". "finished=when user return the car". "on-board=when user is using the car"');
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
            $table->dropColumn('status');
        });
    }
}
