<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigurationsTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('name_en')->after('name')->nullable()->comment('translation');
            $table->string('alias')->after('name_en')->unique()->comment('unique identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            if(Schema::hasColumn('configurations','name_en')){
                $table->dropColumn('name_en');
            }
            if(Schema::hasColumn('configurations','alias')){
                $table->dropColumn('alias');
            }

        });
    }
}
