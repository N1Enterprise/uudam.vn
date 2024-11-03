<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnShippingZoneIdToProviderProviderShippingFeeHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_shipping_fee_histories', function (Blueprint $table) {
            $table->foreignId('shipping_zone_id')->nullable();
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
            $table->dropColumn('shipping_zone_id');
        });
    }
}
