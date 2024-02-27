<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProviderShippingFeeHistoryIdToUserOrderShippingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_order_shipping_histories', function (Blueprint $table) {
            $table->foreignId('provider_shipping_fee_history_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_order_shipping_histories', function (Blueprint $table) {
            $table->dropColumn('provider_shipping_fee_history_id');
        });
    }
}
