<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();
            $table->string('order_no');
            $table->json('meal_raw');
            $table->unsignedDecimal('amount', 8, 0);
            $table->unsignedBigInteger('status');
            $table->bigInteger('user_id');
            $table->bigInteger('purchase_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
