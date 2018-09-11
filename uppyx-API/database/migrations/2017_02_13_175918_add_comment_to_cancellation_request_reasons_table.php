<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentToCancellationRequestReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cancellation_request_reasons', function (Blueprint $table) {
            $table->text('comment')->after('reason')->nullable()->comment('comment of request cancellation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cancellation_request_reasons', function (Blueprint $table) {
            $table->dropColumn('comment');
        });
    }
}
