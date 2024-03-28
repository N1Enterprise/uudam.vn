@extends('frontend.layouts.checkout')

@section('page_title')
Trạng thái đơn hàng #{{ $order->order_code }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! generate_seo_html(['page_name' => "Trạng thái đơn hàng #" . $order->order_code]) !!}
@endsection

@section('style')
<link href="{{ asset_with_version('vendor/validate/styles.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_with_version('frontend/bundle/css/variable.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_with_version('frontend/bundle/css/quick-add.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_with_version('frontend/bundle/css/main.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    input:disabled,
    select:disabled {
        background: #f9f9f9;
    }

    .quick-add-modal__toggle .icon {
        width: 1rem;
    }
    .quick-add-modal__toggle {
        width: auto;
        padding: .5rem;
    }

    .ls-box-title {
        font-family: Poppins,sans-serif;
        font-size: 24px;
        font-weight: 400;
        margin: 10px 0;
        color: #000;
    }

    @media screen and (max-width: 600px) {
        .quick-add-modal__content {
            margin-top: 20px;
        }

        .quick-add-modal__content-info {
            padding: 1rem;
        }

        .quick-add-modal__toggle {
            top: 20px;
            right: 1.5rem;
        }
    }

    @media screen and (max-width: 400px) {
        .quick-add-modal__content {
            margin-top: 0;
            height: 100%;
            overflow: scroll;
            width: 100%;
        }
    }

    .create-address-form .msg-error {
        display: block;
        margin-top: 5px;
    }

    .prevent {
        opacity: .5;
    }

    .error-block {
        padding: 12px 16px;
        width: 100%;
        font-size: 13px;
        line-height: 20px;
        background-color: rgb(255, 241, 241);
        border-radius: 10px;
        margin-bottom: 12px;
    }

    .error-block__generic {
        color: rgb(165, 27, 0);
    }

    .error-block__spec {
        color: rgb(0, 0, 0);
    }

    .order-info {
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        justify-content: space-between;
        box-shadow: rgb(242, 242, 242) 0px -1px 0px inset;
        padding: 12px 0px;
        font-size: 13px;
        line-height: 20px;
        font-weight: 400;
    }

    .order-info__left {
        color: rgb(120, 120, 120);
    }

    .order-info__right {
        color: rgb(36, 36, 36);
    }

    .method-icon {
        border-radius: 4px;
        width: 32px;
        margin-right: 4px;
    }

    .button-block {
        display: flex;
        margin-top: 12px;
    }

    .button-block button {
        font-weight: 500;
        flex: 1 1 0%;
        max-width: 50%;
        height: 44px;
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        outline: 0px;
        cursor: pointer;
    }
    .button-left {
        background: #000;
        color: #fff;
        margin-right: 2px;
    }
    .button-right {
        border: 1px solid #000;
        color: #000;
        margin-left: 2px;
    }
    .contact_link {
        color: #0043ff;
    }

    .wrap-of-status {
        flex-direction: column!important;
        margin-top: 30px;
    }
</style>
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
