<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment(CurrencyType::class);
            $table->string('name');
            $table->char('code', 30)->comment('for fiat use iso3 format.');
            $table->string('symbol')->nullable();
            $table->tinyInteger('decimals')->default(2);
            $table->tinyInteger('status')->default(1)->comment(ActivationStatus::class);
            $table->json('used_countries')->nullable();
            $table->timestamps();
        });

        DB::unprepared(file_get_contents(__DIR__.'/../currencies.sql'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
