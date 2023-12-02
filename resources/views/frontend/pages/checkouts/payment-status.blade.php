@extends('frontend.layouts.checkout')

@section('style')
<style>
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
        text-transform: capitalize;
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
</style>
@endsection

@section('content_body')
<div class="_16s97g7s" style="--_16s97g7o: span 2;">
    <div class="_1frageme0 _1fragemfi _1mrl40q2 _1fragemgb _1fragemgs _16s97g7c _16s97g7k _16s97g718 _16s97g71g   _16s97g788" style="--_16s97g78: minmax(0, 1fr); --_16s97g7g: 1fr; --_16s97g714: minmax(0, 1fr); --_16s97g71c: minmax(0, 1fr) minmax(auto, max-content);">
        <div class="_1fragemfe _1fragemfk _1fragemed _1frageme0">
            <div class="_1fragemfc _1fragem8d _1fragema9 _1fragem6h _1fragemc5 _1frageme0 _16s97g77s  _16s97g732" style="--_16s97g72y: 65rem;">
                <main id="checkout-main" class="_1fragemfc _1fragem8e _1fragemaa _1fragem6i _1fragemc6 _1frageme0 _16s97g7ac">
                    <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg3 _1fragemgk">

                        <section class="_1fragemf0 _1fragemex _1fragemfc _1fragem8c _1fragem99 _1fragema8 _1fragemb5 _1fragem6g _1fragem7d _1fragemc4 _1fragemd1 _1fragemm8 _1frageme0">
                            <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">
                                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemfx _1fragemge">
                                    <h2 class="n8k95w1 _1frageme0 n8k95w2">Thanh toán {{ $order->isSucceed() ? 'thành công' : 'không thành công' }}</h2>
                                </div>

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
                                        <div style="display: flex; align-items: center;">
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
                                        <li style="display: flex; align-items: center;">
                                            <span style="margin-right: 3px;">Số điện thoại:</span>
                                            <div>
                                                <a href="tel:{{ data_get($PAGE_SETTINGS, 'phone_support.phone') }}" class="contact_link">{{ data_get($PAGE_SETTINGS, 'phone_support.phone') }}</a>
                                                <span>({{ data_get($PAGE_SETTINGS, 'phone_support.label') }})</span>
                                            </div>
                                        </li>
                                        <li style="display: flex; align-items: center;">
                                            <span style="margin-right: 3px;">Zalo:</span>
                                            <div>
                                                <a href="https://zalo.me/{{ data_get($PAGE_SETTINGS, 'phone_zalo.phone') }}" target="_blank" class="contact_link">{{ data_get($PAGE_SETTINGS, 'phone_zalo.phone') }}</a>
                                                <span>({{ data_get($PAGE_SETTINGS, 'phone_zalo.label') }})</span>
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
                        </section>
                    </div>
                </main>
            </div>
        </div>
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
