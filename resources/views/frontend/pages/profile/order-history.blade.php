@extends('frontend.layouts.profile')

@section('profile_style')
<style>
    .order-history {
        background: #fafafa;
        border-radius: 3px;
        padding: 10px;
        margin-bottom: 20px;
    }

    .order-history-status {
        padding: 2px 10px;
        border-radius: 5px;
        font-weight: bold;
        background: rgb(60 75 77 / 20%);
        line-height: 19px;
    }

    .cart__items {
        border-bottom: none!important;
    }

    .cart-item__image-container {
        position: relative;
    }

    .order-history-item-quantity {
        position: absolute;
        bottom: 0;
        right: 0;
        font-size: 12px;
        line-height: 16px;
        font-weight: 400;
        color: rgb(128, 128, 137);
        text-align: center;
        position: absolute;
        width: 28px;
        height: 28px;
        background-color: rgb(235, 235, 240);
        display: flex;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        right: 0px;
        bottom: 0px;
        border-top-left-radius: 10px;
    }
</style>
@endsection

@section('profile_content')
<div class="profile-change-password">
    <h4>Lịch sử đơn hàng</h4>
    <div class="order-list">
        @if(count($orders))
            @foreach ($orders as $order)
            <div class="order-history">
                <div class="order-history__basic-info" style="display: flex; align-items: center; margin-bottom: 10px;">
                    <div class="order-history-status">{{ enum('OrderStatusEnum')::findConstantLabelVn($order->order_status) }}</div>
                    <span style="padding: 0 10px;">|</span>
                    <div class="order-history-created_at">Ngày đặt: {{ format_datetime($order->created_at, 'd/m/Y H:i') }}</div>
                </div>
                <div class="order-history__items cart__items" id="main-cart-items">
                    <table class="cart-items">
                        <tbody>
                            @foreach (data_get($order, 'orderItems', []) as $item)
                            <tr class="cart-item order-history__items-item">
                                <td class="cart-item__media">
                                    <div class="cart-item__image-container gradient global-media-settings">
                                        <img src="{{ data_get($item, 'inventory.image') }}" class="" alt="{{ data_get($item, 'inventory.title') }}" loading="lazy" width="100" height="100">
                                        <span class="order-history-item-quantity">x{{ data_get($item, 'quantity') }}</span>
                                    </div>
                                </td>

                                <td class="cart-item__details">
                                    <div>
                                        <a href="{{ route('fe.web.products.index', data_get($item, 'inventory.slug')) }}" class="cart-item__name h4 break">{{ data_get($item, 'inventory.title') }}</a>
                                        <div class="product-option order-item-price" style="margin-top: 10px;">{{ format_price(data_get($item, 'price')) }}</div>
                                    </div>
                                    <dl>
                                        @php
                                            $attributeValues = data_get($item, 'inventory.attributeValues')->pluck('value', 'attribute_id')->toArray();
                                        @endphp
                                        @foreach (data_get($item, 'inventory.attributes', []) as $attribute)
                                        <div class="product-option">
                                            <dt>{{ data_get($attribute, 'name') }}: </dt>
                                            <dd>{{ data_get($attributeValues, [data_get($attribute, 'id')]) }}</dd>
                                        </div>
                                        @endforeach
                                    </dl>
                                    <p class="product-option"></p>
                                    <ul class="discounts list-unstyled" role="list" aria-label="Discount"></ul>
                                </td>

                                <td class="cart-item__totals right small-hide">
                                    <div class="cart-item__price-wrapper">
                                        <span class="price price--end">{{ format_price($item->total_price) }}</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="order-history__sumary" style="display: flex; flex-direction: column; justify-content: flex-end; align-items: flex-end;">
                    <div style="padding: 10px 0; font-size: 18px;">
                        <span>Tổng tiền:</span>
                        <span style="font-weight: bold;">{{ format_price($order->grand_total) }}</span>
                    </div>
                    <div class="buttons">
                        <a href="{{ route('fe.web.user.profile.order-history-detail', $order->order_code) }}">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <b>Bạn chưa có đơn hàng nào!</b>
        @endif
    </div>
</div>
@endsection

@section('profile_js')
@endsection
