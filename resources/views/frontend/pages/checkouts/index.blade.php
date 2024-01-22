@extends('frontend.layouts.checkout')

@section('page_title')
Thanh toán | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
<meta property="og:title" content="Thanh toán | {{ config('app.user_domain') }}">
<meta property="og:description" content="Thanh toán | {{ config('app.user_domain') }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }} }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
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
</style>
@endsection

@section('content_body')
<div class="content">
    <input type="hidden" name="checkout_cart_uuid" value="{{ request()->cartUuid }}">
    <div class="wrap">
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="order-summary order-summary-is-collapsed">
                    <h2 class="visually-hidden">Thông tin đơn hàng</h2>
                    <div class="order-summary-sections">
                        <div class="order-summary-section order-summary-section-product-list" data-order-summary-section="line-items">
                            <table class="product-table">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <span class="visually-hidden">Hình ảnh</span>
                                        </th>
                                        <th scope="col">
                                            <span class="visually-hidden">Mô tả</span>
                                        </th>
                                        <th scope="col">
                                            <span class="visually-hidden">Số lượng</span>
                                        </th>
                                        <th scope="col">
                                            <span class="visually-hidden">Giá</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="product" data-product-id="1051432518" data-variant-id="1115802864">
                                        <td class="product-image">
                                            <div class="product-thumbnail">
                                                <div class="product-thumbnail-wrapper">
                                                    <img class="product-thumbnail-image" alt="Tinh dầu khô hỗ trợ giảm đau bụng kinh" src="//product.hstatic.net/1000405402/product/tron_nhan_tdk_92ad92b1b571438b84e859abfac9b980_small.jpg">
                                                </div>
                                                <span class="product-thumbnail-quantity" aria-hidden="true">5</span>
                                            </div>
                                        </td>
                                        <td class="product-description">
                                            <span class="product-description-name order-summary-emphasis">Tinh dầu khô hỗ trợ giảm đau bụng kinh</span>
                                            <span class="product-description-variant order-summary-small-text"> Hộp gỗ nhẵn mịn / 20 gram </span>
                                        </td>
                                        <td class="product-quantity visually-hidden">5</td>
                                        <td class="product-price">
                                            <span class="order-summary-emphasis">1,375,000₫</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="order-summary-section order-summary-section-discount" data-order-summary-section="discount">
                            <form id="form_discount_add" accept-charset="UTF-8" method="post">
                                <input name="utf8" type="hidden" value="✓">
                                <div class="fieldset">
                                    <div class="field  ">
                                        <div class="field-input-btn-wrapper">
                                            <div class="field-input-wrapper">
                                                <label class="field-label" for="discount.code">Mã giảm giá</label>
                                                <input placeholder="Mã giảm giá" class="field-input" data-discount-field="true" autocomplete="false" autocapitalize="off" spellcheck="false" size="30" type="text" id="discount.code" name="discount.code" value="">
                                            </div>
                                            <button type="submit" class="field-input-btn btn btn-default btn-disabled">
                                                <span class="btn-content">Sử dụng</span>
                                                <i class="btn-spinner icon icon-button-spinner"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="order-summary-section order-summary-section-redeem redeem-login-section" data-order-summary-section="discount">
                            <div class="redeem-login">
                                <div class="redeem-login-title">
                                    <a href="">Chương trình khách hàng thân thiết</a>
                                    <i class="btn-redeem-spinner icon-redeem-button-spinner"></i>
                                </div>
                            </div>
                        </div>
                        <div class="order-summary-section order-summary-section-total-lines payment-lines" data-order-summary-section="payment-lines">
                            <table class="total-line-table">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <span class="visually-hidden">Mô tả</span>
                                        </th>
                                        <th scope="col">
                                            <span class="visually-hidden">Giá</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="total-line total-line-subtotal">
                                        <td class="total-line-name">Tạm tính</td>
                                        <td class="total-line-price">
                                            <span class="order-summary-emphasis" data-checkout-subtotal-price-target="137500000"> 1,375,000₫ </span>
                                        </td>
                                    </tr>
                                    <tr class="total-line total-line-shipping">
                                        <td class="total-line-name">Phí vận chuyển</td>
                                        <td class="total-line-price">
                                            <span class="order-summary-emphasis" data-checkout-total-shipping-target="0"> — </span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="total-line-table-footer">
                                    <tr class="total-line">
                                        <td class="total-line-name payment-due-label">
                                            <span class="payment-due-label-total">Tổng cộng</span>
                                        </td>
                                        <td class="total-line-name payment-due">
                                            <span class="payment-due-currency">VND</span>
                                            <span class="payment-due-price" data-checkout-payment-due-target="137500000"> 1,375,000₫ </span>
                                            <span class="checkout_version" display:none="" data_checkout_version="43"></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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
                        <form id="form-order" action="{{ empty($order->id) ? route('fe.api.user.order.store', request()->cartUuid) : route('fe.api.user.order.reorder', $order->order_code) }}" data-form="order" accept-charset="UTF-8" method="post" style="width: 100%;">
                            <input name="utf8" type="hidden" value="✓">
                            <button type="submit" class="step-footer-continue-btn btn" style="width: 100%;">
                                <span class="btn-content">Đặt hàng</span>
                                <i class="btn-spinner icon icon-button-spinner"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="hrv-coupons-popup">
                <div class="hrv-title-coupons-popup">
                    <p>Chọn giảm giá <span class="count-coupons"></span>
                    </p>
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
