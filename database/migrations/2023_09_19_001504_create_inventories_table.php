<?php

use App\Enum\ActivationStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('product_id')->index();
            $table->tinyInteger('condition')->comment(InventoryConditionEnum::class);
            $table->string('condition_note')->nullable();
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->tinyInteger('status')->comment(ActivationStatusEnum::class);
            $table->json('key_features')->nullable();
            $table->decimal('purchase_price', 27, 8)->nullable();
            $table->decimal('sale_price', 27, 8)->nullable();
            $table->decimal('offer_price', 27, 8)->nullable();
            $table->dateTime('offer_start')->nullable();
            $table->dateTime('offer_end')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_order_quantity')->default(0);
            $table->dateTime('available_from')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('image')->nullable();
            $table->morphs('created_by');
            $table->morphs('updated_by');

            $table->softDeletes();
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
        Schema::dropIfExists('inventories');
    }
}
