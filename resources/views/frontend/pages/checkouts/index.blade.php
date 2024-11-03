@extends('frontend.layouts.checkout')

@section('page_title')
{{ get_static_page_seo_title('checkout') }}
@endsection

@section('page_seo')
{!! generate_static_page_seo_html('checkout') !!}
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/checkout.min.css') }}">
@endsection

@section('content_body')
<button class="order-summary-toggle order-summary-toggle-hide">
    <div class="wrap">
        <div class="order-summary-toggle-inner">
            <div class="order-summary-toggle-icon-wrapper">
                <svg width="20" height="19" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle-icon"><path d="M17.178 13.088H5.453c-.454 0-.91-.364-.91-.818L3.727 1.818H0V0h4.544c.455 0 .91.364.91.818l.09 1.272h13.45c.274 0 .547.09.73.364.18.182.27.454.18.727l-1.817 9.18c-.09.455-.455.728-.91.728zM6.27 11.27h10.09l1.454-7.362H5.634l.637 7.362zm.092 7.715c1.004 0 1.818-.813 1.818-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817zm9.18 0c1.004 0 1.817-.813 1.817-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817z"></path></svg>
            </div>
            <div class="order-summary-toggle-text order-summary-toggle-text-show">
                <span>Hiển thị thông tin đơn hàng</span>
                <svg width="11" height="6" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle-dropdown" fill="#000"><path d="M.504 1.813l4.358 3.845.496.438.496-.438 4.642-4.096L9.504.438 4.862 4.534h.992L1.496.69.504 1.812z"></path></svg>
            </div>
            <div class="order-summary-toggle-text order-summary-toggle-text-hide">
                <span>Ẩn thông tin đơn hàng</span>
                <svg width="11" height="7" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle-dropdown" fill="#000"><path d="M6.138.876L5.642.438l-.496.438L.504 4.972l.992 1.124L6.138 2l-.496.436 3.862 3.408.992-1.122L6.138.876z"></path></svg>
            </div>
            <div class="order-summary-toggle-total-recap">
                <span class="total-recap-final-price" data-checkout-payment-due-target>-</span>
            </div>
        </div>
    </div>
</button>
<div class="content">
    <input type="hidden" name="checkout_cart_uuid" value="{{ request()->cartUuid }}">
    <div class="wrap">
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="order-summary order-summary-is-collapsed">
                    <h2 class="visually-hidden">Thông tin đơn hàng</h2>
                    <div class="order-summary-sections">
                        @include('frontend.pages.checkouts.partials.order-summary-items')

                        @include('frontend.pages.checkouts.partials.order-summary-discount')

                        @include('frontend.pages.checkouts.partials.order-summary-total')
                    </div>
                </div>
            </div>
        </div>
        <div class="main">
            <div class="main-header">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('fe.web.cart.index') }}">Giỏ hàng</a>
                    </li>
                    <li class="breadcrumb-item breadcrumb-item-current">Thanh toán</li>
                </ul>
            </div>
            <div class="main-content">
                <div id="checkout_order_information_changed_error_message" class="hidden" style="margin-bottom:15px">
                    <p class="field-message field-message-error alert alert-danger">
                        <svg x="0px" y="0px" viewBox="0 0 286.054 286.054" style="enable-background:new 0 0 286.054 286.054;" xml:space="preserve">
                            <g>
                                <path style="fill:#E2574C;" d="M143.027,0C64.04,0,0,64.04,0,143.027c0,78.996,64.04,143.027,143.027,143.027 c78.996,0,143.027-64.022,143.027-143.027C286.054,64.04,222.022,0,143.027,0z M143.027,259.236 c-64.183,0-116.209-52.026-116.209-116.209S78.844,26.818,143.027,26.818s116.209,52.026,116.209,116.209 S207.21,259.236,143.027,259.236z M143.036,62.726c-10.244,0-17.995,5.346-17.995,13.981v79.201c0,8.644,7.75,13.972,17.995,13.972 c9.994,0,17.995-5.551,17.995-13.972V76.707C161.03,68.277,153.03,62.726,143.036,62.726z M143.036,187.723 c-9.842,0-17.852,8.01-17.852,17.86c0,9.833,8.01,17.843,17.852,17.843s17.843-8.01,17.843-17.843 C160.878,195.732,152.878,187.723,143.036,187.723z"></path>
                            </g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                        </svg>
                        <span></span>
                    </p>
                </div>
                <div class="step">
                    <div class="step-sections steps-onepage">
                        <div class="section">
                            @include('frontend.pages.checkouts.partials.shipment-details')

                            <div id="change_pick_location_or_shipping">
                                @include('frontend.pages.checkouts.partials.shipping-methods')
                                @include('frontend.pages.checkouts.partials.payment-methods')
                            </div>
                        </div>
                    </div>
                    <div class="step-footer" id="step-footer-checkout">
                        @if(has_data($address))
                        <form id="form-order" action="{{ empty($order->id) ? route('fe.api.user.order.store', request()->cartUuid) : route('fe.api.user.order.reorder', $order->order_code) }}" data-form="order" accept-charset="UTF-8" method="post" style="width: 100%;">
                            <input name="utf8" type="hidden" value="✓">
                            <button type="submit" class="step-footer-continue-btn btn prevent" style="width: 100%;" disabled>
                                <span class="btn-content">Đang cập nhật ...</span>
                                <i class="btn-spinner icon icon-button-spinner"></i>
                            </button>
                        </form>
                        @else
                        <form accept-charset="UTF-8" style="width: 100%;">
                            <div style="color: #025B50;">
                                Bạn chưa có địa chỉ giao hàng - vui lòng nhấn vào đây <button type="button" class="button show-modal-add-address" style="padding: 5px 8px; background-color: #025B50!important; color: #fff; border-radius: 3px;">Thêm địa chỉ</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="hrv-coupons-popup">
                <div class="hrv-title-coupons-popup">
                    <p>Chọn giảm giá <span class="count-coupons"></span></p>
                    <div class="hrv-coupons-close-popup">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.1663 2.4785L15.5213 0.833496L8.99968 7.35516L2.47801 0.833496L0.833008 2.4785L7.35468 9.00016L0.833008 15.5218L2.47801 17.1668L8.99968 10.6452L15.5213 17.1668L17.1663 15.5218L10.6447 9.00016L17.1663 2.4785Z" fill="#424242"></path>
                        </svg>
                    </div>
                </div>
                <div class="hrv-content-coupons-code">
                    <h3 class="coupon_heading">Mã giảm giá của shop</h3>
                    <div class="hrv-discount-code-web"></div>
                    <div class="hrv-discount-code-external"></div>
                </div>
            </div>
            <div class="hrv-coupons-popup-site-overlay"></div>
        </div>
    </div>
</div>

@include('frontend.pages.checkouts.partials.modal-address')
@endsection

@section('js_scipt')
<script src="{{ asset_with_version('frontend/assets/js/common/main.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('vendor/validate/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('vendor/validate/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/checkout-index.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/address.min.js') }}" type="text/javascript"></script>
@endsection
