<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyXGetYTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_x_get_y', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->bigInteger('price_rule_id');
            $table->integer('quantity_buy');
            $table->bigInteger('collection_id_buy');
            $table->bigInteger('product_id_buy');
            $table->bigInteger('product_variant_id_buy');
            $table->integer('quantity_get');
            $table->bigInteger('collection_id_get');
            $table->bigInteger('product_id_get');
            $table->bigInteger('product_variant_id_get');
            $table->timestamps();

            $table->foreign('price_rule_id')->references('id')->on('price_rule')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('collection_id_buy')->references('id')->on('custom_collections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('collection_id_get')->references('id')->on('custom_collections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id_buy')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id_get')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_variant_id_buy')->references('id')->on('product_variants')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_variant_id_get')->references('id')->on('product_variants')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_x_get_y');
    }
}
