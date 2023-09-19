<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->index();
            $table->foreignId('inventory_id')->index();
            $table->foreignId('attribute_value_id')->index();
            $table->string('sku')->nullable();
            $table->integer('stock_quantity')->default(0);

            $table->decimal('purchase_price', 27, 8)->nullable();
            $table->decimal('sale_price', 27, 8)->nullable();

            $table->decimal('offer_price', 27, 8)->nullable();
            $table->dateTime('offer_start')->nullable();
            $table->dateTime('offer_end')->nullable();
            $table->json('description')->nullable();

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
        Schema::dropIfExists('attribute_inventories');
    }
}
