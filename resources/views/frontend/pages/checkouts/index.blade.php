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

    /* @media screen and (min-width: 990px) {
        .quick-add-modal__content {
            width: 40%;
        }
    } */

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
</style>
@endsection

@section('content_body')
<div class="content">
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
                        <a href="/cart">Giỏ hàng</a>
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
                    <div class="step-sections steps-onepage" step="1">
                        <div class="section">

                            @include('frontend.pages.checkouts.partials.shipment-details')

                            {{-- <div class="section-content">
                                <div class="fieldset">
                                    <form autocomplete="off" id="form_update_shipping_method" class="field " accept-charset="UTF-8" method="post">
                                        <input name="utf8" type="hidden" value="✓">
                                        <div class="content-box mt0">
                                            <div class="radio-wrapper content-box-row">
                                                <label class="radio-label">
                                                    <div class="radio-input">
                                                        <input type="radio" id="customer_pick_at_location_false" name="customer_pick_at_location" class="input-radio" value="false" checked="">
                                                    </div>
                                                    <span class="radio-label-primary">Giao tận nơi</span>
                                                </label>
                                            </div>
                                            <div id="form_update_location_customer_shipping" class="order-checkout__loading radio-wrapper content-box-row content-box-row-padding content-box-row-secondary " for="customer_pick_at_location_false">
                                                <input name="utf8" type="hidden" value="✓">
                                                <div class="order-checkout__loading--box">
                                                    <div class="order-checkout__loading--circle"></div>
                                                </div>
                                                <div class="field field-required  ">
                                                    <div class="field-input-wrapper">
                                                        <label class="field-label" for="billing_address_address1">Địa chỉ</label>
                                                        <input placeholder="Địa chỉ" autocapitalize="off" spellcheck="false" class="field-input" size="30" type="text" id="billing_address_address1" name="billing_address[address1]" value="">
                                                    </div>
                                                </div>
                                                <input name="selected_customer_shipping_country" type="hidden" value="">
                                                <input name="selected_customer_shipping_province" type="hidden" value="">
                                                <input name="selected_customer_shipping_district" type="hidden" value="">
                                                <input name="selected_customer_shipping_ward" type="hidden" value="">
                                                <div class="field field-show-floating-label field-required field-third ">
                                                    <div class="field-input-wrapper field-input-wrapper-select">
                                                        <label class="field-label" for="customer_shipping_province"> Tỉnh / thành </label>
                                                        <select class="field-input" id="customer_shipping_province" name="customer_shipping_province">
                                                            <option data-code="null" value="null" selected=""> Chọn tỉnh / thành </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="field field-show-floating-label field-required field-third ">
                                                    <div class="field-input-wrapper field-input-wrapper-select">
                                                        <label class="field-label" for="customer_shipping_district">Quận / huyện</label>
                                                        <select class="field-input" id="customer_shipping_district" name="customer_shipping_district">
                                                            <option data-code="null" value="null" selected="">Chọn quận / huyện</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="field field-show-floating-label field-required  field-third  ">
                                                    <div class="field-input-wrapper field-input-wrapper-select">
                                                        <label class="field-label" for="customer_shipping_ward">Phường / xã</label>
                                                        <select class="field-input" id="customer_shipping_ward" name="customer_shipping_ward">
                                                            <option data-code="null" value="null" selected="">Chọn phường / xã</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="div_location_country_not_vietnam" class="section-customer-information " style="display: none;">
                                                    <div class="field field-two-thirds">
                                                        <div class="field-input-wrapper">
                                                            <label class="field-label" for="billing_address_city">Thành phố</label>
                                                            <input placeholder="Thành phố" autocapitalize="off" spellcheck="false" class="field-input" size="30" type="text" id="billing_address_city" name="billing_address[city]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="field field-third">
                                                        <div class="field-input-wrapper">
                                                            <label class="field-label" for="billing_address_zip">Mã bưu chính</label>
                                                            <input placeholder="Mã bưu chính" autocapitalize="off" spellcheck="false" class="field-input" size="30" type="text" id="billing_address_zip" name="billing_address[zip]" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="radio-wrapper content-box-row">
                                                <label class="radio-label">
                                                    <div class="radio-input">
                                                        <input type="radio" id="customer_pick_at_location_true" name="customer_pick_at_location" class="input-radio" value="true">
                                                    </div>
                                                    <span class="radio-label-primary">Nhận tại cửa hàng</span>
                                                </label>
                                            </div>
                                            <div id="form_update_location_customer_pick_at_location" class="radio-wrapper content-box-row content-box-row-padding content-box-row-secondary hidden" for="customer_pick_at_location_true">
                                                <input name="utf8" type="hidden" value="✓">
                                                <input name="inventory_location_country_id" type="hidden" value="241">
                                                <div class="field field-third ">
                                                    <div class="field-input-wrapper field-input-wrapper-select">
                                                        <label class="field-label" for="inventory_location_province">Tỉnh / thành</label>
                                                        <select class="field-input" id="inventory_location_province" name="inventory_location_province">
                                                            <option data-code="null" value="null" selected="">Chọn tỉnh / thành</option>
                                                            <option data-code="DA" value="32">Đà Nẵng</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> --}}

                            <div id="change_pick_location_or_shipping">
                                <div class="inventory_location"></div>
                                <div id="section-shipping-rate">
                                    <div class="order-checkout__loading--box">
                                        <div class="order-checkout__loading--circle"></div>
                                    </div>
                                    <div class="section-header">
                                        <h2 class="section-title">Phương thức vận chuyển</h2>
                                    </div>
                                    <div class="section-content">
                                        <div class="content-box  blank-slate">
                                            <i class="blank-slate-icon icon icon-closed-box "></i>
                                            <p>Vui lòng chọn tỉnh / thành để có danh sách phương thức vận chuyển.</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="section-payment-method" class="section">
                                    <div class="order-checkout__loading--box">
                                        <div class="order-checkout__loading--circle"></div>
                                    </div>
                                    <div class="section-header">
                                        <h2 class="section-title">Phương thức thanh toán</h2>
                                    </div>
                                    <div class="section-content">
                                        <div class="content-box">
                                            <div class="radio-wrapper content-box-row">
                                                <label class="radio-label" for="payment_method_id_1002148193">
                                                    <div class="radio-input payment-method-checkbox">
                                                        <input type-id="1" id="payment_method_id_1002148193" class="input-radio" name="payment_method_id" type="radio" value="1002148193" checked="">
                                                    </div>
                                                    <div class="radio-content-input">
                                                        <img class="main-img" src="https://hstatic.net/0/0/global/design/seller/image/payment/cod.svg?v=6">
                                                        <div>
                                                            <span class="radio-label-primary">Thanh toán khi giao hàng (COD)</span>
                                                            <span class="quick-tagline hidden"></span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="radio-wrapper content-box-row">
                                                <label class="radio-label" for="payment_method_id_1002574592">
                                                    <div class="radio-input payment-method-checkbox">
                                                        <input type-id="2" id="payment_method_id_1002574592" class="input-radio" name="payment_method_id" type="radio" value="1002574592">
                                                    </div>
                                                    <div class="radio-content-input">
                                                        <img class="main-img" src="https://hstatic.net/0/0/global/design/seller/image/payment/other.svg?v=6">
                                                        <div>
                                                            <span class="radio-label-primary">Chuyển khoản qua ngân hàng</span>
                                                            <span class="quick-tagline hidden"></span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="radio-wrapper content-box-row content-box-row-secondary hidden" for="payment_method_id_1002574592">
                                                <div class="blank-slate"> Thông tin tài khoản ngân hàng: Ngân hàng: ACB CHI NHÁNH ĐÀ NẴNG Tên tài khoản: CÔNG TY CP LERUSTIQUE VIỆT NAM Số tài khoản: 2707918888 Nội dung: [số điện thoại] – [tên khách hàng] Sau khi hoàn tất đơn hàng, nhân viên Le Rustique sẽ liên hệ xác nhận đơn cho bạn nhé. Le Rustique cảm ơn bạn rất nhiều. </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-footer" id="step-footer-checkout">
                        <form id="form_next_step" accept-charset="UTF-8" method="post" style="width: 100%;">
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
