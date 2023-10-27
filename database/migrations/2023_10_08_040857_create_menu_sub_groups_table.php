<?php

use App\Enum\ActivationStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuSubGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_sub_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('redirect_url')->nullable();
            $table->foreignId('menu_group_id')->index();
            $table->json('params')->nullable();
            $table->tinyInteger('order')->nullable();
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
        Schema::dropIfExists('menu_sub_groups');
    }
}
