<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnShippingRateIdToUserOrderShippingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_order_shipping_histories', function (Blueprint $table) {
            $table->foreignId('shipping_rate_id')->nullable();
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
            $table->dropColumn('shipping_rate_id');
        });
    }
}
