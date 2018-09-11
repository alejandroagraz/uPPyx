<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProviderToSocialLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_logins', function (Blueprint $table) {
            $table->dropColumn('provider');
        });

        Schema::table('social_logins', function (Blueprint $table) {
            $table->enum('provider', ['twitter', 'facebook', 'instagram', 'google'])->after('user_id')->comment('social provider');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_logins', function (Blueprint $table) {
            $table->dropColumn('provider');
        });

        Schema::table('social_logins', function (Blueprint $table) {
            $table->enum('provider', ['twitter', 'facebook', 'instagram', 'google+'])->after('user_id');
        });
    }
}
