<?php

use App\Enum\CartItemStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->index();
            $table->foreignId('inventory_id')->index();
            $table->foreignId('user_id')->index();
            $table->text('note')->nullable();
            $table->string('uuid')->unique();
            $table->string('currency_code');
            $table->boolean('has_combo')->default(0);
            $table->integer('quantity')->default(0);
            $table->decimal('price', 20, 6)->default(0);
            $table->decimal('total_price', 20, 6)->nullable();
            $table->tinyInteger('status')->comment(CartItemStatusEnum::class);
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
        Schema::dropIfExists('cart_items');
    }
}
