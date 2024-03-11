<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('email')->nullable();
            $table->string('phone', 15);
            $table->char('province_code', 10);
            $table->char('district_code', 10);
            $table->char('ward_code', 10);
            $table->boolean('is_default', 10);
            $table->text('address_line')->nullable();
            $table->string('addressable_type')->nullable();
            $table->foreignId('addressable_id')->nullable()->index();
            $table->timestamps();

            $table->index(['addressable_id', 'province_code', 'district_code', 'ward_code'], 'addressable_id_province_district_ward');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
