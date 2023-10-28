<?php

use App\Enum\ActivationStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('primary_image')->nullable();
            $table->text('cover_image')->nullable();
            $table->string('cta_label')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('featured')->comment(ActivationStatusEnum::class);
            $table->tinyInteger('status')->comment(ActivationStatusEnum::class);
            $table->tinyInteger('display_on_frontend')->comment(ActivationStatusEnum::class);
            $table->integer('order')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->json('linked_inventories')->nullable();
            $table->json('linked_featured_inventories')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
