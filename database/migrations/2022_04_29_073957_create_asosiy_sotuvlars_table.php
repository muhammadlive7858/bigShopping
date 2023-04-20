<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsosiySotuvlarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asosiy_sotuvlars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('fullname');
            $table->string('savdo');
            $table->string('foyda');
            $table->integer('client_id')->nullable();
            $table->string('skidka')->nullable();
            $table->string('naxt')->nullable();
            $table->string('plastik')->nullable();
            $table->string('month');
            $table->string('year');
            $table->string('day');
            $table->string('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asosiy_sotuvlars');
    }
}
