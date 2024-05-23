@extends('frontend.layouts.profile')

@section('page_title')
Chi tiết đơn hàng #{{ $order->order_code }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! generate_static_page_seo_html('profile_order_history_detail', [':order_code' => $order->order_code]) !!}
@endsection

@section('profile_style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/profile.min.css') }}">
@endsection

@php
    $orderStatusBg = '';

    switch ($order->order_status) {
        case enum('OrderStatusEnum')::DECLINED:
        case enum('OrderStatusEnum')::PAYMENT_ERROR:
        case enum('OrderStatusEnum')::CANCELED:
            $orderStatusBg = '#a8a8a8';
            break;
        case enum('OrderStatusEnum')::WAITING_FOR_PAYMENT:
        case enum('OrderStatusEnum')::REFUNDED:
        case enum('OrderStatusEnum')::DELIVERY:
            $orderStatusBg = '#ddb865';
            break;
        case enum('OrderStatusEnum')::PROCESSING:
        case enum('OrderStatusEnum')::COMPLETED:
            $orderStatusBg = '#59a198';
            break;
        default:
            break;
    };
@endphp

@section('profile_content')
<div class="profile-change-password">
    <h4>Chi tiết đơn hàng <b>#{{ $order->order_code }}</b>
        -
        <span>{{ enum('OrderStatusEnum')::findConstantLabelVn($order->order_status) }}</span>
    </h4>
    <div class="order-history-created_at" style="margin-bottom: 20px; font-size: 14px; font-weight: bold;">Đặt lúc: {{ format_datetime($order->created_at, 'd/m/Y H:i') }}</div>

    <div class="order-status-wrapper" style="margin-bottom: 20px;">
        <div style="border-radius: 3px; color: #fff; font-weight: bold; text-transform: uppercase; padding: 10px; background: {{ $orderStatusBg }}">Đơn hàng {{ enum('OrderStatusEnum')::findConstantLabelVn($order->order_status) }}</div>
    </div>

    <div class="order-info">
        <div class="order-info__item">
            <h3 style="margin: 5px 0; margin-bottom: 7px;">#1. Thông tin người nhận</h3>
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
            <h3 style="margin: 5px 0; margin-bottom: 7px;">#2. Hình thức giao hàng</h3>
            <div>
                <div>
                    <small style="margin-top: 10px;">Phương thức vận chuyển:</small>
                    <span>{{ data_get($order->shippingOption, 'name') }}</span>
                </div>

                <div>
                    <small style="margin-top: 10px;">Phí vận chuyển:</small>
                    <span>{{ format_price(data_get($order->latestUserOrderShippingHistory, ['estimated_transport_fee'])) }}</span>
                </div>
            </div>
        </div>

        <div class="order-info__item">
            <h3 style="margin: 5px 0; margin-bottom: 7px;">#3. Hình thức thanh toán</h3>
            <div>
                <div style="display: flex; align-items: center;">
                    @if(data_get($order, ['paymentOption', 'logo']))
                    <img class="method-icon" src="{{ data_get($order, ['paymentOption', 'logo']) }}" width="30" height="30" alt="{{ data_get($order, ['paymentOption', 'name']) }}">
                    @endif
                    <small style="display: block; margin-left: 10px;">{{ data_get($order, ['paymentOption', 'name']) }}</small>
                </div>

                @if (data_get($order->paymentOption, 'expanded_content'))
                <div id="expanded_content_{{ data_get($order->paymentOption, 'id') }}" data-expanded-content-payment-option-id="{{ data_get($order->paymentOption, 'id') }}" style="background-color: #f9f9f9; padding: 10px; margin-top: 10px;">
                    @php
                        $orderTransferContent = implode('', [
                            'UD',
                            data_get($order->cart, 'id'),
                        ]);

                        $expandedContent = str_replace('${order_transfer_content}', $orderTransferContent, data_get($order->paymentOption, 'expanded_content'));
                    @endphp

                    <p style="font-size: 13px; margin: 0;">{!! nl2br($expandedContent) !!}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="order-info__item">
            <h3 style="margin: 5px 0; margin-bottom: 7px;">#4. Chi tiết đơn hàng</h3>
            <div>
                <table class="cart-items">
                    <tbody>
                        @foreach (data_get($order, 'orderItems', []) as $item)
                        <tr class="cart-item order-history__items-item">
                            <td class="cart-item__media" width="150">
                                <div class="cart-item__image-container" style="margin-right: 9px;">
                                    <img src="{{ data_get($item, 'inventory.image') }}" class="" alt="{{ data_get($item, 'inventory.title') }}" loading="lazy" width="100" height="100">
                                    <span class="order-history-item-quantity">x{{ data_get($item, 'quantity') }}</span>
                                </div>
                            </td>

                            <td class="cart-item__details" style="flex-direction: column;">
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
                                        <span>{{ data_get($attribute, 'name') }}: </dt>
                                        <span>{{ data_get($attributeValues, [data_get($attribute, 'id')]) }}</span>
                                    </div>
                                    @endforeach
                                </dl>
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
                <button id="btn-cancel-order" class="btn" style="padding: 5px; min-height: 15px; margin: 0;">Huỷ đơn hàng</button>
                @endif
            </div>
        </div>
    </div>
</div>

@if($order->canCancel())
<div class="cancel-order-modal">
    <quick-add-modal id="modal-cancel-order" style class="quick-add-modal">
        <div class="quick-add-modal__content global-settings-popup no-bottom mobile-position-center" tabindex="-1">
            <div id="ModalClose-4441599705221" type="button" class="quick-add-modal__toggle" data-overlay-close>
                <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                    <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
                </svg>
            </div>
            <div class="quick-add-modal__content-info">
                <div>
                    <div class="quick-add-modal__content-heading">
                        <h3 class="ls-box-title text-left" style="margin-bottom: 0; font-size: 22px;">Lý do huỷ đơn hàng #{{ $order->order_code }}</h3>
                    </div>
                    <div class="quick-add-modal__content-content">
                        <div>
                            <form method="POST" action="{{ route('fe.api.user.sale.order.cancel', $order->order_code) }}" id="cancel_order_form" accept-charset="UTF-8" class="signin-form">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for=""><b>Lý do:</b></label>
                                    <div class="field field--with-error" style="margin: 5px 0;">
                                        <select class="field-input" id="reason" name="reason">
                                            <option value="" selected="">-- Chọn lý do huỷ --</option>
                                            @foreach ($orderCancelReasons as $reason)
                                            <option value="{{ data_get($reason, 'code') }}">{{ data_get($reason, 'reason') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for=""><b>Chi tiết:</b></label>
                                    <div class="field field--with-error" style="margin: 5px 0;">
                                        <textarea name="content" class="field__input" cols="30" rows="5" placeholder="Chi tiết" style="min-height: 100px;" required></textarea>
                                        <label class="field__label" for="content">Chi tiết <span>*</span></label>
                                    </div>
                                </div>

                                <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;" data-button-submit-text disabled>Xác Nhận</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </quick-add-modal>
</div>
@endif

@endsection

@section('profile_js')
<script src="{{ asset_with_version('frontend/bundle/js/order-history.min.js') }}" type="text/javascript"></script>
@endsection
