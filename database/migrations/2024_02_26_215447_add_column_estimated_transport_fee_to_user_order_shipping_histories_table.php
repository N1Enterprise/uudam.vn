<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEstimatedTransportFeeToUserOrderShippingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_order_shipping_histories', function (Blueprint $table) {
            $table->decimal('estimated_transport_fee', 20, 6)->nullable();
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
            $table->dropColumn('estimated_transport_fee');
        });
    }
}
