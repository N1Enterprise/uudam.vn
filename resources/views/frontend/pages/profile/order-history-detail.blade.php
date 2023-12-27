@extends('frontend.layouts.profile')

@section('page_title')
Lịch sử đơn hàng | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
<meta property="og:title" content="Lịch sử đơn hàng | {{ config('app.user_domain') }}">
<meta property="og:description" content="Lịch sử đơn hàng | {{ config('app.user_domain') }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }} }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
@endsection

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
    <h4>Chi tiết đơn hàng <b>#{{ $order->order_code }}</b>
        -
        <span>{{ enum('OrderStatusEnum')::findConstantLabelVn($order->order_status) }}</span>
    </h4>
    <div class="order-info">
        <div class="order-info__item">
            <h3>#1. Thông tin người nhận</h3>
            <div>
                <small>Họ và tên:</small>
                <span>{{ $order->fullname }}</span>
            </div>
            <div>
                <small>E-mail:</small>
                <span>{{ $order->email }}</span>
            </div>
            <div>
                <small>Số điện thoại:</small>
                <span>{{ $order->phone }}</span>
            </div>
            <div>
                <small>Công ty:</small>
                <span>{{ $order->company ?? 'N/A' }}</span>
            </div>
            <div>
                <small>Địa chỉ:</small>
                <span>{{ $order->address_line }}</span> /
                <small>Thành phố</small>:
                {{ $order->city_name }}</span> /
                <small>Mã bưu điện</small>:
                {{ $order->postal_code ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="order-info__item">
            <h3>#2. Hình thức giao hàng</h3>
            <div>
                <div style="display: flex; align-items: center;">
                    <img src="{{ data_get($order, ['shippingRate', 'carrier', 'logo']) }}" width="30" height="30" alt="{{ data_get($order, ['shippingRate', 'carrier', 'name']) }}">
                    <span style="margin-left: 10px;">{{ data_get($order, ['shippingRate', 'carrier', 'name']) }}</span>
                </div>

                <small style="margin-top: 5px; display: block;">{{ data_get($order, ['shippingRate', 'name']) }}</small>

                <div>
                    <small style="margin-top: 5px;">Phí vận chuyển:</small>
                    <span>{{ format_price(data_get($order, ['shippingRate', 'rate'])) }}</span>
                </div>
            </div>
        </div>

        <div class="order-info__item">
            <h3>#3. Hình thức thanh toán</h3>
            <div>
                <div style="display: flex; align-items: center;">
                    @if(data_get($order, ['paymentOption', 'logo']))
                    <img class="method-icon" src="{{ data_get($order, ['paymentOption', 'logo']) }}" width="30" height="30" alt="{{ data_get($order, ['paymentOption', 'name']) }}">
                    @endif
                    <small style="display: block; margin-left: 10px;">{{ data_get($order, ['paymentOption', 'name']) }}</small>
                </div>
            </div>
        </div>

        <div class="order-info__item">
            <h3>#4. Chi tiết đơn hàng</h3>
            <div>
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

                @if($order->canCancel())
                <div class="buttons">
                    <div>Để huỷ đơn vui lòng liên hệ với chúng tôi qua:</div>
                    <div>
                        <small>Số điện thoại:</small>
                        <a href="tel:{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}">{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}</a>
                        <span>({{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.label') }})</span>
                    </div>
                    <div>
                        <small>Zalo:</small>
                        <a href="https://zalo.me/{{ data_get($SYSTEM_SETTING, 'page_settings.phone_zalo.phone') }}" target="_blank">{{ data_get($SYSTEM_SETTING, 'page_settings.phone_zalo.phone') }}</a>
                        <span>({{ data_get($SYSTEM_SETTING, 'page_settings.phone_zalo.label') }})</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
