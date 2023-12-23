<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\HomePageDisplayType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePageDisplayItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_page_display_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('group_id');
            $table->integer('order')->nullable();
            $table->tinyInteger('type')->comment(HomePageDisplayType::class);
            $table->json('linked_items')->nullable();
            $table->boolean('status')->comment(ActivationStatusEnum::class);
            $table->boolean('display_on_frontend')->comment(ActivationStatusEnum::class);
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
        Schema::dropIfExists('home_page_display_items');
    }
}
