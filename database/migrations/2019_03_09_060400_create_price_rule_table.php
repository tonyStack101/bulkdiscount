<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_rule', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('title');
            $table->enum('value_type', ['fixed_amount', 'percentage', 'free_shipping', 'buy_x_get_y']);
            $table->integer('value');
            $table->enum('customer_selection', ['all', 'prerequisite']);
            $table->enum('target_type', ['line_item', 'shipping_line']);
            $table->enum('target_selection', ['all', 'entitled']);
            $table->enum('allocation_method', ['each', 'across']);
            $table->integer('allocation_limit');
            $table->boolean('once_per_customer')->default(false);
            $table->integer('usage_limit');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->double('prerequisite_subtotal_range', 8, 2)->nullable();
            $table->integer('prerequisite_quantity_range')->nullable();
            $table->double('prerequisite_shipping_price_range', 8, 2)->nullable();
            $table->bigInteger('shop_id');
            $table->primary('id');
            $table->index('id');
            $table->timestamps();

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
        Schema::dropIfExists('price_rule');
    }
}
