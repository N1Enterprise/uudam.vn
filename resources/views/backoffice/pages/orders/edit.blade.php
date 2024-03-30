@extends('backoffice.layouts.master')

@php
	$title = __('Chi tiết đơn hàng');

	$breadcrumbs = [
		[
			'label' => __('Quản lí đơn hàng'),
		],
		[
			'label' => $title,
		]
	];

    $orderStatusClass = '';

    switch ($order->order_status) {
        case enum('OrderStatusEnum')::WAITING_FOR_PAYMENT:
            $orderStatusClass = 'badge badge-secondary';
            break;
        case enum('OrderStatusEnum')::PAYMENT_ERROR:
            $orderStatusClass = 'badge badge-warning';
            break;
        case enum('OrderStatusEnum')::PROCESSING:
            $orderStatusClass = 'badge badge-primary';
            break;
        case enum('OrderStatusEnum')::DELIVERY:
            $orderStatusClass = 'badge badge-secondary';
            break;
        case enum('OrderStatusEnum')::COMPLETED:
            $orderStatusClass = 'badge badge-success';
            break;
        case enum('OrderStatusEnum')::CANCELED:
            $orderStatusClass = 'badge badge-danger';
            break;
        case enum('OrderStatusEnum')::REFUNDED:
            $orderStatusClass = 'badge badge-warning';
            break;
        default:
            break;
    }

    $paymentStatusClass = '';

    switch ($order->payment_status) {
        case enum('PaymentStatusEnum')::DECLINED:
        case enum('PaymentStatusEnum')::CANCELED:
        case enum('PaymentStatusEnum')::FAILED:
            $paymentStatusClass = 'badge badge-danger';
            break;
        case enum('PaymentStatusEnum')::PENDING:
            $paymentStatusClass = 'badge badge-primary';
            break;
        case enum('PaymentStatusEnum')::APPROVED:
            $paymentStatusClass = 'badge badge-success';
            break;
        default:
            break;
    }
@endphp

@section('header')
{{ __($title) }}
@endsection

@section('style')
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="row">
		<div class="col-md-12">
			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">
                            <span>{{ __('Thông tin đơn hàng') }}</span>
                            <b>#{{ $order->order_code }}</b>
                        </h3>

                        <div data-toggle="tooltip" data-title="{{ __('Order Status') }}" class="order_status {{ $orderStatusClass }}" style="margin-left: 10px; text-transform: uppercase;">{{ $order->order_status_name }} {{ __('Thứ tự') }}</div>

                        <span style="padding: 0 10px;">|</span>

                        <div data-toggle="tooltip" data-title="{{ __('Payment Status') }}" class="order_status {{ $paymentStatusClass }}" style="text-transform: uppercase;">{{ $order->payment_status_name }} {{ __('Payment') }}</div>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#order_tab" role="tab" aria-selected="true">
									{{ __('Thông tin đơn hàng') }}
								</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#address_shipping_tab" role="tab" aria-selected="true">
									{{ __('Thông tin vận chuyển') }}
								</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#payment_tab" role="tab" aria-selected="true">
									{{ __('Thông tin thanh toán') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

                <div class="k-portlet__body">
                    <div class="tab-content">
                        {{-- Order Tab --}}
                        <div class="tab-pane active show" id="order_tab" role="tabpanel">
                            <div class="user_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#1. {{ __('Thông tin chung') }}</h5>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Mã đơn hàng') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->order_code }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('UUID') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->uuid }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label><a href="{{ route('bo.web.users.edit', $order->user->id) }}" target="_bank">{{ __('ID khách hàng') }}</a></label>
                                        <input type="text" class="form-control" value="{{ $order->user->id }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Tên khách hàng') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->user->name }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Tổng sản phẩm') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->total_item }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Tổng số lượng') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->total_quantity }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Taxrate') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->taxrate }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Tổng khối lượng') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->shipping_weight }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Tổng giá sản phẩm') }}</label>
                                        <input type="text" class="form-control" value="{{ format_price($order->total_price) }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Đơn giá (Tổng giá sản phẩm + phí vận chuyển)') }}</label>
                                        <input type="text" class="form-control" value="{{ format_price($order->grand_total) }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Khách hàng ghi chú') }}</label>
                                        <textarea cols="20" rows="3" class="form-control" disabled>{{ $order->user_note }}</textarea>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Quản trị ghi chú') }}</label>
                                        <textarea cols="20" rows="3" class="form-control" disabled>{{ $order->admin_note }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="order-items">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#2. {{ __('Sản phẩm') }}</h5>
                                <table id="table_order_items_index" data-searching="true" data-request-url="{{ route('bo.api.order-items.index', ['order_id' => $order->id]) }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                                    <thead>
                                        <tr>
                                            <th data-property="id">{{ __('ID') }}</th>
                                            <th data-orderable="false" data-property="inventory.image" data-render-callback="renderCallbackImage">{{ __('Image') }}</th>
                                            <th data-link="inventory.edit" data-link-target="_blank" data-orderable="false" data-property="inventory.title" data-render-callback="renderCallbackImage">{{ __('Tên') }}</th>
                                            <th data-property="currency_code">{{ __('Currency Code') }}</th>
                                            <th data-property="quantity">{{ __('Quantity') }}</th>
                                            <th data-property="price">{{ __('Price') }}</th>
                                            <th data-property="total_price">{{ __('Total Price') }}</th>
                                            <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                                            <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Address Shipping Tab --}}
                        <div class="tab-pane" id="address_shipping_tab" role="tabpanel">
                            <div class="address_shipping_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#3. {{ __('Địa chỉ nhận hàng') }}</h5>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Tên khách hàng') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->fullname }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('E-mail') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->email }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Số điện thoại') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->phone }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Mã quốc gia') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->country_code }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Công ty') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->company }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Mã bưu điện') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->postal_code }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Tỉnh/Thành Phố') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->province_name }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Quận/Huyện') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->district_name }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Phường/Xã') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->ward_name }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="address_shipping_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#4. {{ __('Thông tin vận chuyển') }}</h5>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Tùy chọn vận chuyển') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->shippingOption->name }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Phí vận chuyển ước tính / Gam') }}</label>
                                        <input type="text" class="form-control" value="{{ format_price(data_get($order->latestUserOrderShippingHistory, ['estimated_transport_fee'])) }} / {{ $order->total_weight }}g" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Đơn vị vận chuyển') }}</label>
                                        <input type="text" class="form-control" value="{{ data_get($order->latestUserOrderShippingHistory, ['shippingProvider', 'name']) }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Phí vận chuyển (đ.v vận chuyển) / Gam') }}</label>
                                        <input type="text" class="form-control" value="{{ format_price($order->transport_fee ?? 0) }} / {{ $order->total_weight }}g" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Mã tham chiếu với đ.v vận chuyển') }}</label>
                                        <input type="text" class="form-control" value="{{ data_get($order->latestUserOrderShippingHistory, ['reference_id']) }}" disabled>
                                    </div>
                                </div>
                                @if ($order->isPendingPayment())
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#process_shipping_order">{{ __('Cập nhật thông tin vận chuyển') }}</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane" id="payment_tab" role="tabpanel">
                            <div class="payment_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#4. {{ __('Thông tin thanh toán') }}</h5>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Phương phức thanh toán') }}</label>
                                        <input type="text" class="form-control" value="{{ data_get($order->paymentOption, ['name']) }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Trạng thái') }}</label>
                                        <input type="text" class="form-control" value="{{ data_get($order->depositTransaction, 'status_name') }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Tổng tiền thanh toán') }}</label>
                                        <input type="text" class="form-control" value="{{ format_price(data_get($order->depositTransaction, 'amount')) }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Ngày tạo') }}</label>
                                        <input type="text" class="form-control" value="{{ data_get($order->depositTransaction, 'created_at') }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Mã tham chiếu') }}</label>
                                        <input type="text" class="form-control" value="{{ data_get($order->depositTransaction, 'reference_id') }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Số lần phê duyệt') }}</label>
                                        <input type="text" class="form-control" value="{{ data_get($order->depositTransaction, 'approved_index') }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>

            <div class="k-portlet k-portlet--tabs">
                <div class="k-portlet__body">
                    <div class="btns d-flex justify-content-end">
                        @can('orders.manage')
                        <button type="submit" data-btn-change-order-status="update-to-delivery" class="btn btn-secondary ml-2" data-route="{{ route('bo.api.orders.delivery', $order->id) }}" {{ !$order->canDelivery() ? 'disabled' : '' }}>{{ __('VẬN CHUYỂN') }}</button>
                        <button type="submit" data-btn-change-order-status="update-to-complete" class="btn btn-success ml-2" data-route="{{ route('bo.api.orders.complete', $order->id) }}" {{ !$order->canComplete() ? 'disabled' : '' }}>{{ __('HOÀN THÀNH') }}</button>
                        <button type="submit" data-btn-change-order-status="update-to-refund" class="btn btn-warning ml-2" data-route="{{ route('bo.api.orders.refund', $order->id) }}" {{ !$order->canRefund() ? 'disabled' : '' }}>{{ __('HOÀN TIỀN') }}</button>
                        <button type="submit" data-btn-change-order-status="update-to-cancel" class="btn btn-danger ml-2" data-route="{{ route('bo.api.orders.cancel', $order->id) }}" {{ !$order->canCancel() ? 'disabled' : '' }}>{{ __('HỦY ĐƠN') }}</button>
                        @endcan
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection

@can('orders.manage')
@push('modals')
<div class="modal fade" id="update_order_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border:none;">
            <form id="update_order_status_form" method="GET" action="">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="admin_note">{{ __('Admin Note') }}</label>
                        <textarea name="admin_note" id="admin_note" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="process_shipping_order" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="order-update-shipping-form" action="{{ route('bo.api.orders.update-shipping', $order->id) }}" method="PUT">
                <input type="hidden" name="user_order_shipping_history_id" value="{{ $order->latestUserOrderShippingHistory->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Thông tin vận chuyển đơn') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ __('Tùy chọn vận chuyển') }}</label>
                            <input type="text" class="form-control" value="{{ $order->shippingOption->name }}" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ __('Phí vận chuyển ước tính') }}</label>
                            <input type="text" class="form-control" value="{{ format_price(data_get($order->latestUserOrderShippingHistory, ['estimated_transport_fee'])) }}" disabled>
                        </div>
                    </div>

                    <div class="row">
                        @if ($order->shippingOption->isShippingZone())
                        <div class="form-group col-md-12">
                            <label>{{ __('Khu vực vận chuyển') }}</label>
                            <input type="text" class="form-control" value="{{ data_get($order->latestUserOrderShippingHistory, ['shippingZone', 'name']) }} ({{ data_get($order->latestUserOrderShippingHistory, ['shippingRate', 'name'], 'N/A') }})" disabled>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ __('Đơn vị vận chuyển') }}</label>
                            <select name="shipping_provider_id" title="-- {{ __('Chọn đơn vị vận chuyển') }} --" class="form-control k_selectpicker" data-live-search="true">
                                @foreach($shippingProviders as $provider)
                                <option {{ old('shipping_provider_id', data_get($order->latestUserOrderShippingHistory, ['shippingProvider', 'id'])) == $provider->id ? 'selected' : '' }} value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>{{ __('Phí vận chuyển (đ.v vận chuyển)') }}</label>
                            <x-number-input allow-minus="false" key="transport_fee" name="transport_fee" class="form-control" value="{{ data_get($order->latestUserOrderShippingHistory, ['transport_fee'], '0') }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ __('Mã tham chiếu với đ.v vận chuyển') }}</label>
                            <input name="reference_id" type="text" class="form-control" value="{{ data_get($order->latestUserOrderShippingHistory, ['reference_id']) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Cập nhật') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush
@endcan

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script>
    function renderCallbackImage(data) {
        const image = $('<img>', {
            src: data,
            width: 80,
            height: 80,
        });

        return image.prop('outerHTML');
    }

    $.each($('[data-btn-change-order-status]'), function(index, element) {
        $(element).on('click', function() {
            $('#update_order_status_modal').find('.modal-title').text($(this).text());
            $('#update_order_status_modal').find('form').attr('action', $(this).attr('data-route'));
            $('#update_order_status_modal').modal('show');
        });
    });

    $('#update_order_status_form').on('submit', function(e) {
        e.preventDefault();

        const _self = $(this);

        $.ajax({
            url: _self.attr('action'),
            method: 'PUT',
            data: _self.serialize(),
            beforeSend: () => {
                _self.find('[type="submit"]').prop('disabled', true);
            },
            success: () => {
                fstoast.success("{{ __('Success to change order status.') }}");
                _self.find('[type="submit"]').prop('disabled', false);
                location.reload();
            },
            error: () => {
                fstoast.error("{{ __('Fail to change order status.') }}");
                _self.find('[type="submit"]').prop('disabled', false);
            },
        });
    });

    $('#order-update-shipping-form').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            user_order_shipping_history_id: $(this).find('[name="user_order_shipping_history_id"]').val(),
            shipping_provider_id: $(this).find('[name="shipping_provider_id"]').val(),
            transport_fee: $(this).find('[name="transport_fee"]').val(),
            reference_id: $(this).find('[name="reference_id"]').val(),
        };

        $.ajax({
            url: $(this).attr('action'),
            method: 'PUT',
            data: payload,
            success: (response) => {
                location.reload();
            },
        });
    });
</script>
@include('backoffice.pages.orders.js-pages.edit')
@endsection
