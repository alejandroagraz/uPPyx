<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->comment('universally unique identifier');
            $table->string('code', 50)->comment('The code the customer enters into the rental request summary');
            $table->boolean('active')->default(1)->comment('If the code can be used');
            $table->enum('discount_operation', ['-', '+', '*', '/', '%'])->comment('The type of discount');
            $table->enum('discount_unit', ['$', '%'])->comment('The unit of discount');
            $table->float('discount_amount')->comment('Discount Amount');
            $table->unsignedInteger('num_uses')->default(1)->comment('Number of times the code can be used');
            $table->date('expiry')->comment('The date the code expires, and is no longer usable');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_codes');
    }
}
