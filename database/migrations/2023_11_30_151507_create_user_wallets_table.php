<?php

use App\Enum\ActivationStatusEnum;
use App\Enum\UserWalletTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->id();
            $table->decimal('balance', 27, 18)->default(0);
            $table->boolean('status')->comment(ActivationStatusEnum::class);
            $table->tinyInteger('type')->comment(UserWalletTypeEnum::class);
            $table->foreignId('user_id')->index();
            $table->char('currency_code', 5);
            $table->foreignId('order_id')->index()->nullable();
            $table->boolean('activated')->default(0);
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
        Schema::dropIfExists('user_wallets');
    }
}
