<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRentalRequest5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //drop column
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        //create status again with new values in enum
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->enum('status', ['sent','cancelled','taken-manager','taken-user','finished','on-board','on-way','cancelled-system'])
                ->after('type')
                ->comment('request status. "sent=when user sent request", "cancelled-system=when system cancel the request". "cancelled=when user cancel the request". "taken-user=when the agent takes the request". "taken-manager=when the manager takes the request". "finished=when user return the car". "on-board=when user is using the car". "on-way=when agent is on the way to deliver the car"');
        });

        Schema::table('rental_requests', function (Blueprint $table) {
            $table->string('credit_card_token')->after('status')->nullable()->comment('Credit card token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop column
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('credit_card_token');
        });

        //create status again with new values in enum
        Schema::table('rental_requests', function (Blueprint $table) {
            $table->enum('status', ['sent','cancelled','taken','finished','on-board'])->after('type')->comment('request status. "sent=when user sent request", "cancelled=when user cancel the request". "taken=when agent take the request". "finished=when user return the car". "on-board=when user is using the car"');
        });


    }
}
