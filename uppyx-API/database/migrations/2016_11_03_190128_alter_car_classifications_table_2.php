<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCarClassificationsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_classifications', function (Blueprint $table) {
            $table->enum('type',['standard','plus'])->after('description')->comment('Type of card classification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_classifications', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
