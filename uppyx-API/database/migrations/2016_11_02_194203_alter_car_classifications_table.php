<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCarClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_classifications', function (Blueprint $table) {
            $table->float('price_high_season')->after('description')->comment('price high season');
            $table->float('price_low_season')->after('description')->comment('price high season');
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
            if(Schema::hasColumn('car_classifications','price_high_season')) {
                $table->dropColumn('price_high_season');
            }

            if(Schema::hasColumn('car_classifications','price_low_season'))
            {
                $table->dropColumn('price_low_season');
            }
        });
    }
}
