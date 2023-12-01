<?php

use App\Enum\DepositStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->decimal('amount', 27, 18);
            $table->tinyInteger('status')->comment(DepositStatusEnum::class);
            $table->foreignId('user_id');
            $table->foreignId('payment_option_id');
            $table->text('note')->nullable();
            $table->json('log')->nullable();
            $table->string('reference_id')->nullable()->unique();
            $table->foreignId('order_id');
            $table->string('currency_code');
            $table->integer('approved_index')->nullable();
            $table->json('provider_payload')->nullable();
            $table->json('bank_transfer_info')->nullable();
            $table->json('provider_response')->nullable();
            $table->morphs('created_by');
            $table->morphs('updated_by');
            $table->timestamps();

            $table->index(['updated_at'], 'updated_at_index');
            $table->index(['status', 'updated_at'], 'status_updated_at_index');
            $table->index(['status', 'created_at'], 'status_created_at_index');
            $table->index(['reference_id'], 'reference_id_index');
            $table->index(['order_id'], 'order_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit_transactions');
    }
}
