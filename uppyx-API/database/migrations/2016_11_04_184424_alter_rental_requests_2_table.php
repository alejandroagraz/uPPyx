<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRentalRequests2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_requests', function (Blueprint $table) {
            if(Schema::hasColumn('rental_requests', 'status')){
                $table->dropForeign('rental_requests_taken_by_user_foreign');
                $table->dropColumn('taken_by_user');
            };

            if(Schema::hasColumn('rental_requests', 'status')){
                $table->dropForeign('rental_requests_taken_by_agency_foreign');
                $table->dropColumn('taken_by_agency');
            }

            if(Schema::hasColumn('rental_requests', 'total_days')){
                $table->dropColumn('total_days');
            }
            if(Schema::hasColumn('rental_requests', 'total_cost')){
                $table->dropColumn('total_cost');
            }

        });

        Schema::table('rental_requests', function (Blueprint $table) {
            if(!Schema::hasColumn('rental_requests', 'taken_by_user')){
                $table->unsignedInteger('taken_by_user')->nullable()->after('user_id')->comment('User Id from users');
                $table->foreign('taken_by_user')->references('id')->on('users');
            }
            if(!Schema::hasColumn('rental_requests', 'taken_by_agency')){
                $table->unsignedInteger('taken_by_agency')->nullable()->after('user_id')->comment('Rental Agency Id. from rental_agencies.');
                $table->foreign('taken_by_agency')->references('id')->on('rental_agencies');
            }
            if(!Schema::hasColumn('rental_requests', 'total_days')){
                $table->integer('total_days')->after('taken_by_user')->nullable()->comment('number of days');
            }
            if(!Schema::hasColumn('rental_requests', 'total_cost')){
                $table->float('total_cost')->after('taken_by_user')->nullable()->comment('total cost of rental');
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
        Schema::table('rental_requests', function (Blueprint $table) {

            if(Schema::hasColumn('rental_requests', 'taken_by_user')){
                $table->dropForeign('rental_requests_taken_by_user_foreign');
                $table->dropColumn('taken_by_user');
            }
            if(Schema::hasColumn('rental_requests', 'taken_by_agency')){
                $table->dropForeign('rental_requests_taken_by_agency_foreign');
                $table->dropColumn('taken_by_agency');
            }

            if(Schema::hasColumn('rental_requests', 'total_days')){
                $table->dropColumn('total_days');
            }

            if(Schema::hasColumn('rental_requests', 'total_cost')){
                $table->dropColumn('total_cost');
            }

        });

        Schema::table('rental_requests', function (Blueprint $table) {

            if(!Schema::hasColumn('rental_requests', 'taken_by_user')){
                $table->unsignedInteger('taken_by_user')->nullable()->after('user_id')->comment('User Id from users');
                $table->foreign('taken_by_user')->references('id')->on('users');
            }

            if(!Schema::hasColumn('rental_requests', 'taken_by_agency')){
                $table->unsignedInteger('taken_by_agency')->nullable()->after('user_id')->comment('Rental Agency Id. from rental_agencies.');
                $table->foreign('taken_by_agency')->references('id')->on('rental_agencies');
            }

            if(!Schema::hasColumn('rental_requests', 'total_days')){
                $table->integer('total_days')->after('taken_by_user')->comment('number of days');
            }
            if(!Schema::hasColumn('rental_requests', 'total_cost')){
                $table->float('total_cost')->after('taken_by_user')->comment('total cost of rental');
            }

        });
    }
}
