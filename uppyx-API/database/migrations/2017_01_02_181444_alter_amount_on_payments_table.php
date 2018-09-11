<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAmountOnPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->float('amount')->after('user_id')->comment('amount of the payment');
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
            $table->dropColumn('amount');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->integer('amount')->after('user_id')->comment('amount of the payment');
        });
    }
}
