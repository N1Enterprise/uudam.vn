<?php

use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->string('uuid')->unique();
            $table->foreignId('user_id');
            $table->string('currency_code');
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('country_code')->nullable();
            $table->string('address_line')->nullable();
            $table->string('city_name')->nullable();
            $table->string('postal_code')->nullable();
            $table->foreignId('shipping_rate_id');
            $table->foreignId('payment_option_id');
            $table->foreignId('deposit_transaction_id')->nullable();
            $table->integer('total_item');
            $table->integer('total_quantity');
            $table->decimal('taxrate', 20, 6)->nullable();
            $table->decimal('shipping_weight', 20, 6)->nullable();
            $table->decimal('total_price', 20, 6)->nullable();
            $table->decimal('taxes', 20, 6)->nullable();
            $table->foreignId('coupon_id')->nullable();
            $table->foreignId('promotion_id')->nullable();
            $table->decimal('grand_total', 20, 6)->nullable();
            $table->date('shipping_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->tinyInteger('payment_status')->comment(PaymentStatusEnum::class);
            $table->tinyInteger('order_status')->comment(OrderStatusEnum::class);
            $table->boolean('is_sent_invoice_to_user')->default(0);
            $table->text('admin_note')->nullable();
            $table->text('user_note')->nullable();
            $table->integer('retry_order_times')->nullable();
            $table->morphs('created_by');
            $table->morphs('updated_by');
            $table->json('log')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id'], 'user_id_index');
            $table->index(['user_id', 'currency_code'], 'user_id_currency_code_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
