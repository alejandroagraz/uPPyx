<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSeasonsTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('seasons');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_date')->comment('date start season');
            $table->date('end_date')->comment('date end season');
            $table->enum('type', ['low', 'high'])->comment();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
