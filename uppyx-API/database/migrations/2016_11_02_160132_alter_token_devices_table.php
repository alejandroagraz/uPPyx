<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTokenDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('token_devices', function(Blueprint $table)
        {
            $table->dropColumn('token');
        });

        Schema::table('token_devices', function(Blueprint $table)
        {
            $table->text('token_device')->after('user_id')->comment('token device');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('token_devices', function(Blueprint $table)
        {
            $table->dropColumn('token_device');
        });

        Schema::table('token_devices', function(Blueprint $table)
        {
            $table->text('token')->after('user_id')->comment('token device');;
        });
    }
}
