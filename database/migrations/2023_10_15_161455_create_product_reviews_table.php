<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\ProductReviewRatingEnum;
use App\Enum\ProductReviewStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('user_phone')->nullable();
            $table->string('user_email')->nullable();
            $table->foreignId('product_id');
            $table->tinyInteger('rating_type')->comment(ProductReviewRatingEnum::class);
            $table->text('content')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->comment(ProductReviewStatusEnum::class);
            $table->tinyInteger('is_real_user')->comment(ActivationStatusEnum::class)->default(ActivationStatusEnum::INACTIVE);
            $table->nullableMorphs('created_by');
            $table->nullableMorphs('updated_by');
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
        Schema::dropIfExists('product_reviews');
    }
}
