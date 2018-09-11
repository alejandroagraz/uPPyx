<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCarClassificationTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_classifications', function (Blueprint $table) {
            if(!Schema::hasColumn('car_classifications','category'))
            {
                $table->enum('category', ['car','suv','van'])->after('description')->comment('vehicle category=> car, suv, van');
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
            if(Schema::hasColumn('car_classifications','category'))
            {
                $table->dropColumn('category');
            }
        });
    }
}
