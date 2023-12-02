<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('user_id');
            $table->foreignId('inventory_id');
            $table->text('item_description')->nullable();
            $table->string('currency_code');
            $table->integer('quantity');
            $table->decimal('price', 20, 6);
            $table->decimal('total_price', 20, 6)->nullable();
            $table->timestamps();

            $table->index(['order_id'], 'order_id_index');
            $table->index(['inventory_id'], 'inventory_id_index');
            $table->index(['user_id'], 'user_id_index');
            $table->index(['user_id', 'currency_code'], 'user_id_currency_code_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
