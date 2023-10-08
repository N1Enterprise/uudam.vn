<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\DisplayInventoryTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisplayInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('display_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id');
            $table->tinyInteger('type')->comment(DisplayInventoryTypeEnum::class);
            $table->integer('order')->nullable();
            $table->string('redirect_url')->nullable();
            $table->tinyInteger('status')->default(1)->comment(ActivationStatusEnum::class);
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
        Schema::dropIfExists('display_inventories');
    }
}
