<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();
            $table->string('meal_name');
            $table->unsignedDecimal('price', 8, 0);
            $table->text('description');
            $table->string('meal_img')->nullable();
            $table->unsignedBigInteger('status')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals');
    }
}
