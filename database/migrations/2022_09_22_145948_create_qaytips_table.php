<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQaytipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qaytips', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('prod_id');
            $table->string('productname');
            $table->string('shop_price');
            $table->string('price');
            $table->string('foyda');
            $table->string('count');
            $table->string('month');
            $table->string('year');
            $table->string('day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qaytips');
    }
}
