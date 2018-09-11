<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStatusOnRentalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('rental_requests', function (Blueprint $table) {
            $table->enum('status', ['sent','cancelled','taken-manager','taken-user','finished','on-board','on-way',
                'cancelled-system', 'cancelled-app'])->after('type')
                ->comment('request status. "sent=when user sent request", "cancelled-system=when system cancel the request",
                 "cancelled-app=when app cancel the request","cancelled=when user cancel the request",
                  "taken-user=when the agent takes the request", "taken-manager=when the manager takes the request",
                   "finished=when user return the car", "on-board=when user is using the car",
                    "on-way=when agent is on the way to deliver the car"');
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

        Schema::table('rental_requests', function (Blueprint $table) {
            $table->enum('status', ['sent','cancelled','taken-manager','taken-user','finished','on-board','on-way','cancelled-system'])
                ->after('type')
                ->comment('request status. "sent=when user sent request", "cancelled-system=when system cancel the request".
                 "cancelled=when user cancel the request". "taken-user=when the agent takes the request".
                  "taken-manager=when the manager takes the request". "finished=when user return the car".
                   "on-board=when user is using the car". "on-way=when agent is on the way to deliver the car"');
        });
    }
}
