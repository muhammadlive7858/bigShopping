<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductHisobotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_hisobots', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->integer('taminotchi')->nullable();
            $table->string('price');
            $table->string('shop_price');
            $table->boolean('dollor');
            $table->string('som')->nullable();
            $table->string('dollors')->nullable();
            $table->float('count');
            
            $table->string('month');
            $table->string('year');
            $table->string('day');
            $table->string('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_hisobots');
    }
}
