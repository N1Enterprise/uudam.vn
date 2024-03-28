<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnHiddenNameToHomePageDisplayOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_page_display_orders', function (Blueprint $table) {
            $table->boolean('hidden_name')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page_display_orders', function (Blueprint $table) {
            $table->dropColumn('hidden_name');
        });
    }
}
