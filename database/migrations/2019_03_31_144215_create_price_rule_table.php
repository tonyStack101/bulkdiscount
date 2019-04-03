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
            $table->string('value_type');
            $table->string('value');
            $table->string('customer_selection');
            $table->string('target_type');
            $table->string('target_selection');
            $table->string('allocation_method');
            $table->string('allocation_limit');
            $table->string('once_per_customer');
            $table->string('usage_limit');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->string('entitled_product_ids');
            $table->string('entitled_variant_ids');
            $table->string('entitled_collection_ids');
            $table->string('entitled_country_ids');
            $table->string('prerequisite_product_ids');
            $table->string('prerequisite_variant_ids');
            $table->string('prerequisite_collection_ids');
            $table->string('prerequisite_saved_search_ids');
            $table->string('prerequisite_customer_ids');
            $table->string('prerequisite_subtotal_range');
            $table->string('prerequisite_quantity_range');
            $table->string('prerequisite_shipping_price_range');
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
