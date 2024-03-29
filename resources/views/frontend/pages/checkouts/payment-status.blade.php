@extends('frontend.layouts.checkout')

@section('page_title')
Trạng thái đơn hàng #{{ $order->order_code }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! generate_seo_html(['page_name' => "Trạng thái đơn hàng #" . $order->order_code]) !!}
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/checkout.min.css') }}">
@endsection

@section('content_body')
<div class="content">
    <div class="wrap wrap-of-status">
        <h2>Thanh toán {{ $order->isSucceed() ? 'thành công' : 'không thành công' }}</h2>

        @if($order->isFailure())
        <div class="error-block">
            @if($order->isPaymentError())
            <span class="error-block__generic">Thanh toán thất bại.</span>
            <span class="error-block__spec">Vui lòng thanh toán lại hoặc chọn phương thức thanh toán khác</span>
            @endif
        </div>
        @endif

        <div class="order-info">
            <div class="order-info__left">Mã đơn hàng</div>
            <div class="order-info__right">{{ $order->order_code }}</div>
        </div>

        <div class="order-info">
            <div class="order-info__left">Phương thức thanh toán</div>
            <div class="order-info__right">
                <div style="display: flex; align-items: center; text-align: right;">
                    @if(optional($order->paymentOption)->logo)
                    <img class="method-icon" src="{{ optional($order->paymentOption)->logo }}">
                    @endif
                    <span class="method-title">{{ optional($order->paymentOption)->name }}</span>
                </div>
            </div>
        </div>

        <div class="order-info" style="box-shadow: none;">
            <div class="order-info__left">Tổng tiền</div>
            <div class="order-info__right">{{ format_price($order->grand_total) }}</div>
        </div>

        @if($order->isFailure())
        <div>
            <div style="margin-bottom: 4px; text-decoration: underline;">Liên hệ bên dưới để được hỗ trợ</div>
            <ul>
                <li style="display: flex; align-items: center; text-align: right;">
                    <span style="margin-right: 3px;">Số điện thoại:</span>
                    <div>
                        <a href="tel:{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}" class="contact_link">{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}</a>
                        <span>({{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.label') }})</span>
                    </div>
                </li>
                <li style="display: flex; align-items: center; text-align: right;">
                    <span style="margin-right: 3px;">Zalo:</span>
                    <div>
                        <a href="https://zalo.me/{{ data_get($SYSTEM_SETTING, 'page_settings.phone_zalo.phone') }}" target="_blank" class="contact_link">{{ data_get($SYSTEM_SETTING, 'page_settings.phone_zalo.phone') }}</a>
                        <span>({{ data_get($SYSTEM_SETTING, 'page_settings.phone_zalo.label') }})</span>
                    </div>
                </li>
            </ul>
            <div class="button-block">
                <button type="button" class="button button-left" data-href="{{ route('fe.web.user.checkout.repayment', $order->order_code) }}">Thanh toán lại</button>
            </div>
        </div>
        @else
        <div class="button-block">
            <button type="button" class="button button-left" data-href="{{ route('fe.web.home') }}">Tiếp tục mua sắm</button>
            <button type="button" class="button button-right" data-href="{{ route('fe.web.user.profile.order-history-detail', $order->order_code) }}">Chi tiết đơn hàng</button>
        </div>
        @endif
    </div>
</div>
@endsection

@section('js_scipt')
<script>
    $('[data-href]').on('click', function() {
        const href = $(this).attr('data-href');
        window.location.href = href;
    });
</script>
@endsection
