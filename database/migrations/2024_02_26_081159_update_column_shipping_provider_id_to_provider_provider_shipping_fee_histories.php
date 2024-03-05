<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnShippingProviderIdToProviderProviderShippingFeeHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_shipping_fee_histories', function (Blueprint $table) {
            $table->foreignId('shipping_provider_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_shipping_fee_histories', function (Blueprint $table) {
            $table->foreignId('shipping_provider_id')->change();
        });
    }
}
