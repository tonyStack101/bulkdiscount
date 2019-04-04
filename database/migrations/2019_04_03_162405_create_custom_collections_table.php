<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_collections', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('title');
            $table->bigInteger('price_rule_id');
            $table->primary('id');
            $table->timestamps();

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
        Schema::dropIfExists('custom_collections');
    }
}
