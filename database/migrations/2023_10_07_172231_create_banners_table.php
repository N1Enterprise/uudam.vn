<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\BannerTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('description')->nullable();
            $table->string('redirect_url')->nullable();
            $table->text('desktop_image')->nullable();
            $table->text('mobile_image')->nullable();
            $table->integer('order')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->tinyInteger('type')->comment(BannerTypeEnum::class);
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
        Schema::dropIfExists('banners');
    }
}
