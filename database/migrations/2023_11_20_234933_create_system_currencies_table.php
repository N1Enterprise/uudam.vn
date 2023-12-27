<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\CurrencyTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_currencies', function (Blueprint $table) {
            $table->char('key', 30);
            $table->primary('key');
            $table->tinyInteger('type')->comment(CurrencyTypeEnum::class);
            $table->string('name');
            $table->char('code', 30)->comment('for fiat use iso3 format.');
            $table->string('symbol')->nullable();
            $table->tinyInteger('decimals')->default(2);
            $table->tinyInteger('status')->default(1)->comment(ActivationStatusEnum::class);
            $table->boolean('is_default')->default(0);
            $table->boolean('is_base')->default(0);
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('system_currencies');
    }
}
