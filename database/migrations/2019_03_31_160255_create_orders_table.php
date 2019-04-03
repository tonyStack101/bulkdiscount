<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigInteger('id');
            $table->bigInteger('shop_id');
            $table->bigInteger('discount_codes_id');
            $table->string('name');
            $table->primary('id');
            $table->index('id');
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('discount_codes_id')->references('id')->on('discount_codes')->onDelete('cascade')->onUpdate('cascade');
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
