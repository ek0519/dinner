<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurchaseMealM2m extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_meal', function (Blueprint $table) {
            $table->bigInteger('purchase_id');
            $table->bigInteger('meal_id');
            $table->bigInteger('user_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_meal', function (Blueprint $table) {
            $table->dropIfExists('purchase_meal');
        });
    }
}
