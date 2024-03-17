<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\VideoTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('order')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('source_url');
            $table->tinyInteger('type')->comment(VideoTypeEnum::class);
            $table->tinyInteger('status')->comment(ActivationStatusEnum::class);
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->foreignId('video_category_id')->nullable();
            $table->boolean('display_on_frontend');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->morphs('created_by');
            $table->morphs('updated_by');
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
        Schema::dropIfExists('videos');
    }
}
