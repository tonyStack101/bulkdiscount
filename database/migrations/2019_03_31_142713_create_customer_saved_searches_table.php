<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSavedSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_saved_searches', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('name', 200);
            $table->bigInteger('shop_id');
            $table->primary('id');
            $table->index('id');

            $table->foreign('shop_id')->references('id')->on('shop');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_saved_searches');
    }
}
