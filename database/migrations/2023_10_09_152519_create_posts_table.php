<?php

use App\Enum\ActivationStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('image')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->dateTime('post_at');
            $table->foreignId('post_category_id');
            $table->morphs('created_by');
            $table->morphs('updated_by');
            $table->tinyInteger('status')->comment(ActivationStatusEnum::class);
            $table->tinyInteger('display_on_frontend')->comment(ActivationStatusEnum::class);
            $table->json('linked_inventories')->nullable();
            $table->integer('order')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
