<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\ShippingRateTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('shipping_zone_id');
            $table->foreignId('carrier_id');
            $table->string('delivery_takes')->nullable();
            $table->tinyInteger('type')->comment(ShippingRateTypeEnum::class);
            $table->decimal('minimum', 20, 6)->nullable();
            $table->decimal('maximum', 20, 6)->nullable();
            $table->decimal('rate', 20, 6)->nullable();
            $table->tinyInteger('status')->comment(ActivationStatusEnum::class);
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
        Schema::dropIfExists('shipping_rates');
    }
}
