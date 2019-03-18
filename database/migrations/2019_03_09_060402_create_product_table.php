<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('title', 1000);
            $table->string('handle', 1000)->nullable();
            $table->text('body_html')->nullable();
            $table->string('image', 2000)->nullable();
            $table->string('custom_collection', 2000)->nullable();
            $table->string('tag', 2000)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->bigInteger('shop_id');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');
            $table->index('id');

            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
