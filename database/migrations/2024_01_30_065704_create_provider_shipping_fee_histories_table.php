<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderShippingFeeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_shipping_fee_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id');
            $table->foreignId('shipping_option_id');
            $table->foreignId('shipping_provider_id');
            $table->foreignId('user_id');
            $table->foreignId('address_id');
            $table->char('currency_code', 10);
            $table->integer('total_item')->default(0);
            $table->integer('total_quantity')->default(0);
            $table->decimal('total_price', 20, 6)->default(0);
            $table->decimal('transport_fee', 20, 6)->nullable();
            $table->json('provider_payload')->nullable();
            $table->float('total_weight')->nullable();
            $table->decimal('total_estimated_amount', 20, 6)->nullable();
            $table->json('log')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('provider_shipping_fee_histories');
    }
}
