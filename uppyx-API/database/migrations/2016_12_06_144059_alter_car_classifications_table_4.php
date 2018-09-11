<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCarClassificationsTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_classifications', function (Blueprint $table) {
            if(Schema::hasColumn('car_classifications','price_high_season'))
            {
                $table->dropColumn('price_high_season');
            }
            if(Schema::hasColumn('car_classifications','price'))
            {
                $table->dropColumn('price');
            }

            if(Schema::hasColumn('car_classifications','price_low_season'))
            {
                $table->dropColumn('price_low_season');
            }
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
            if(!Schema::hasColumn('car_classifications','price'))
            {
                $table->float('price')->default('50')->after('title')->comment('price regular season');
            }
            if(!Schema::hasColumn('car_classifications','price_low_season'))
            {
                $table->float('price_low_season')->default('50')->after('title')->comment('price low season');
            }
            if(!Schema::hasColumn('car_classifications','price_high_season'))
            {
                $table->float('price_high_season')->default('50')->after('title')->comment('price high season');
            }
        });
    }
}
