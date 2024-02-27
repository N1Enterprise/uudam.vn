<?php

namespace App\Models;

use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Models\Traits\HasCurrency;
use App\Models\Traits\HasImpactor;
use App\Models\Traits\HasMoney;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
    use HasImpactor;
    use SoftDeletes;
    use HasCurrency;
    use HasMoney;

    protected $fillable = [
        'uuid',
        'order_code',
        'user_id',
        'currency_code',
        'fullname',
        'email',
        'phone',
        'company',
        'country_code',
        'address_line',
        'city_name',
        'postal_code',
        'shipping_rate_id',
        'payment_option_id',
        'shipping_option_id',
        'total_item',
        'total_quantity',
        'taxrate',
        'shipping_weight',
        'total_price',
        'taxes',
        'coupon_id',
        'promotion_id',
        'grand_total',
        'deposit_transaction_id',
        'shipping_date',
        'delivery_date',
        'payment_status',
        'order_status',
        'log',
        'is_sent_invoice_to_user',
        'admin_note',
        'user_note',
        'retry_order_times',
        'created_by_id',
        'created_by_type',
        'updated_by_id',
        'updated_by_type',
        'footprint',
        'province_name',
        'district_name',
        'ward_name',
        'transport_fee',
        'total_weight'
    ];

    protected $casts = [
        'log' => 'json',
        'footprint' => 'json'
    ];

    public function getPaymentStatusNameAttribute()
    {
        return PaymentStatusEnum::findConstantLabel($this->payment_status);
    }

    public function getOrderStatusNameAttribute()
    {
        return OrderStatusEnum::findConstantLabel($this->order_status);
    }

    public function getOrderStatusNameVnAttribute()
    {
        return OrderStatusEnum::findConstantLabel($this->order_status);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function depositTransaction()
    {
        return $this->hasOne(DepositTransaction::class);
    }

    public function paymentOption()
    {
        return $this->belongsTo(PaymentOption::class);
    }

    public function shippingRate()
    {
        return $this->belongsTo(ShippingRate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function isDelivery()
    {
        return $this->order_statys == OrderStatusEnum::DELIVERY;
    }

    public function isProcessing()
    {
        return $this->order_status == OrderStatusEnum::PROCESSING;
    }

    public function isPendingPayment()
    {
        return $this->payment_status == PaymentStatusEnum::PENDING;
    }

    public function isSucceed()
    {
        return in_array($this->order_status, [
            OrderStatusEnum::WAITING_FOR_PAYMENT,
            OrderStatusEnum::PROCESSING,
            OrderStatusEnum::DELIVERY,
            OrderStatusEnum::COMPLETED,
        ]);
    }

    public function isFailure()
    {
        return in_array($this->order_status, [
            OrderStatusEnum::PAYMENT_ERROR,
            OrderStatusEnum::CANCELED,
            OrderStatusEnum::REFUNDED,
        ]);
    }

    public function canDelivery()
    {
        return in_array($this->order_status, [
            OrderStatusEnum::WAITING_FOR_PAYMENT,
            OrderStatusEnum::PROCESSING,
        ]);
    }

    public function canComplete()
    {
        $canOrder = in_array($this->order_status, [
            OrderStatusEnum::DELIVERY,
            OrderStatusEnum::PROCESSING,
            OrderStatusEnum::CANCELED,
            OrderStatusEnum::REFUNDED,
        ]);

        $canPayment = in_array($this->payment_status, [
            PaymentStatusEnum::PENDING,
            PaymentStatusEnum::APPROVED,
        ]);

        return $canOrder && $canPayment;
    }

    public function canCancel()
    {
        return in_array($this->order_status, [
            OrderStatusEnum::WAITING_FOR_PAYMENT,
            OrderStatusEnum::PROCESSING,
            OrderStatusEnum::DELIVERY,
        ]);
    }

    public function canRefund()
    {
        return in_array($this->order_status, [
            OrderStatusEnum::PROCESSING,
            OrderStatusEnum::COMPLETED,
        ]);
    }

    public function canChangeOrderStatus()
    {
        return in_array($this->order_status, [
            OrderStatusEnum::WAITING_FOR_PAYMENT,
            OrderStatusEnum::PAYMENT_ERROR,
            OrderStatusEnum::PROCESSING,
            OrderStatusEnum::DELIVERY,
        ]);
    }

    public function canChangePaymentStatus()
    {
        return in_array($this->payment_status, [
            PaymentStatusEnum::PENDING,
        ]);
    }

    public function isPaymentError()
    {
        return $this->order_status == OrderStatusEnum::PAYMENT_ERROR;
    }

    public function getDescribingPaymentContent()
    {
        return vsprintf('PAY FOR ORDER CODE %s. AMOUNT IS %s %s', [
            $this->order_code,
            $this->toMoney('grand_total')->__toString(),
            $this->currency_code,
        ]);
    }

    public function shippingOption()
    {
        return $this->belongsTo(ShippingOption::class);   
    }

    public function userOrderShippingHistory()
    {
        return $this->hasMany(UserOrderShippingHistory::class);
    }

    public function latestUserOrderShippingHistory()
    {
        return $this->hasOne(UserOrderShippingHistory::class)->latest();
    }
}
