<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\MenuTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('is_new')->default(0);
            $table->tinyInteger('type')->comment(MenuTypeEnum::class);
            $table->foreignId('collection_id')->index()->nullable();
            $table->foreignId('inventory_id')->index()->nullable();
            $table->foreignId('post_id')->index()->nullable();
            $table->integer('order')->nullable();
            $table->json('meta')->nullable();
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
        Schema::dropIfExists('menus');
    }
}
