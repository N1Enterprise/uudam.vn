<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\ProductTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->index();
            $table->string('slug')->unique()->index();
            $table->string('branch')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment(ActivationStatusEnum::class);
            $table->tinyInteger('type')->comment(ProductTypeEnum::class);
            $table->text('primary_image')->nullable();
            $table->json('media')->nullable();
            $table->morphs('created_by');
            $table->morphs('updated_by');

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
        Schema::dropIfExists('products');
    }
}
