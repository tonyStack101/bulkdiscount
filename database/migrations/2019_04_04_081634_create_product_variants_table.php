<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->bigInteger('product_id');
            $table->bigInteger('product_image_id');
            $table->bigInteger('title');
            $table->double('price', 8, 2);
            $table->bigInteger('price_rule_id');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_image_id')->references('id')->on('product_image')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('price_rule_id')->references('id')->on('price_rule')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
