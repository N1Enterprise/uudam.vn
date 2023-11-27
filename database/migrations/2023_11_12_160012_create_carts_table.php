<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('ip_address')->nullable();
            $table->string('currency_code');
            $table->foreignId('address_id')->nullable()->index();
            $table->integer('total_item')->default(0);
            $table->string('uuid')->unique();
            $table->integer('total_quantity')->default(0);
            $table->decimal('total_price', 20, 6);
            $table->foreignId('order_id')->nullable();

            $table->index(['user_id'], 'user_id_index');
            $table->index(['user_id', 'address_id'], 'user_id_address_id_index');
            $table->index(['order_id'], 'order_id_index');

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
        Schema::dropIfExists('carts');
    }
}
