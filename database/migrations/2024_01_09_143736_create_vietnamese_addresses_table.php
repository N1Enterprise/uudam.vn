<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVietnameseAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(file_get_contents(__DIR__.'/../administrative_regions.sql'));
        DB::unprepared(file_get_contents(__DIR__.'/../administrative_units.sql'));
        DB::unprepared(file_get_contents(__DIR__.'/../districts.sql'));
        DB::unprepared(file_get_contents(__DIR__.'/../provinces.sql'));
        DB::unprepared(file_get_contents(__DIR__.'/../wards.sql'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wards');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('administrative_units');
        Schema::dropIfExists('administrative_regions');
    }
}
