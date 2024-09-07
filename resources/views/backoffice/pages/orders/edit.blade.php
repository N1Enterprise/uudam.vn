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
@endphp

@section('header')
{{ __($title) }}
@endsection

@section('style')
<style>
.address-detail-content {
    display: inline-block;
    border: 2px dashed #E8E8E8;
    margin-left: 0px;
    padding: 5px 10px;
    cursor: pointer;
    margin-top: 7px;
}

.order-transfer-content {
    border: 2px dashed #E8E8E8;
    border-radius: 4px;
    padding: 10px;
    background-color: #fefefe;
}
</style>
@endsection

@php
    $orderStatusBadge = 'badge-secondary';

    switch ($order->order_status) {
        case enum('OrderStatusEnum')::DECLINED:
        case enum('OrderStatusEnum')::PAYMENT_ERROR:
        case enum('OrderStatusEnum')::CANCELED:
            $orderStatusBadge = 'badge-danger';
            break;
        case enum('OrderStatusEnum')::REFUNDED:
            $orderStatusBadge = 'badge-secondary';
            break;
        case enum('OrderStatusEnum')::WAITING_FOR_PAYMENT:
        case enum('OrderStatusEnum')::DELIVERY:
            $orderStatusBadge = 'badge-warning';
            break;
        case enum('OrderStatusEnum')::PROCESSING:
            $orderStatusBadge = 'badge-info';
            break;
        case enum('OrderStatusEnum')::COMPLETED:
            $orderStatusBadge = 'badge-success';
            break;
        default:
            break;
    };
@endphp

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <div class="row">
        <div class="col-md-6">
            <div class="pt-2 pb-4 d-flex align-items-center">
                <h3 class="m-0 b-0">#{{ $order->order_code }}</h3>
                <span style="padding: 0 10px;">|</span>
                <span class="badge {{ $orderStatusBadge }}">{{ $order->order_status_name }}</span>
            </div>
        </div>
        <div class="col-md-6">
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
    <div class="row">
        <div class="col-md-8">
            <div class="k-portlet">
                <div class="k-portlet__head">
                    <div class="k-portlet__head-label">
                        <h3 class="k-portlet__head-title">{{ __('Thông tin khách hàng') }}</h3>
                    </div>
                </div>
                <div class="k-portlet__body">
                    <div class="form-group">
                        <label for=""><b>{{ __('Tên khách hàng') }}</b></label>
                        <a href="{{ route('bo.web.users.edit', $order->user_id) }}" target="_blank" class="d-block">
                            <span>{{ $order->fullname }}</span>
                        </a>
                    </div>

                    <div class="form-group">
                        <label for=""><b>{{ __('Địa chỉ giao hàng') }}</b></label>
                        <div class="address-detail">
                            <div>{{ $order->fullname ?? 'N/A' }} - {{ $order->phone ?? 'N/A' }} - {{ $order->email ?? 'N/A' }}</div>
                            <div class="address-detail-content copy-text-click" data-copy-reference=".address-detail-content">{{ $order->full_address }}</div>
                            <div>
                                <a href="https://www.google.com/maps/search/{{ $order->full_address }}" target="_blank" class="d-inline-block btn btn-secondary btn-sm mt-2">{{ __('Xem google map') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="k-portlet">
                <div class="k-portlet__head">
                    <div class="k-portlet__head-label">
                        <h3 class="k-portlet__head-title">
                            <i class="la la-money mr-1" style="font-size: 23px; display: inline-block; transform: translateY(2px);"></i>
                            <span>{{ $order->payment_status_name }}</span>
                        </h3>
                    </div>
                </div>
                <div class="k-portlet__body">
                    <div class="alert alert-outline-accent fade show p-3" role="alert">
                        <div class="d-flex justify-content-between w-100">
                            <div style="color: #3d4465;">Khách phải trả: <b>{{ format_price($order->grand_total) }}</b></div>
                            <div style="color: #3d4465;">Đã thanh toán: 0</div>
                            <div style="color: #3d4465;">Còn phải trả: <b class="text-danger">{{ format_price($order->grand_total) }}</b></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for=""><b>{{ __('Hình thức thanh toán') }}</b></label>
                                <div>
                                    <img class="p-1" style="border: 1px solid #ccc; border-radius: 7px;" src="{{ data_get($order->paymentOption, ['logo']) }}" alt="{{ data_get($order->paymentOption, ['name']) }}" width="40" height="40">
                                    <span>{{ data_get($order->paymentOption, ['name']) }}</span>
                                </div>
                            </div>
                        </div>

                        @if (data_get($order->paymentOption, ['expanded_content']))
                        <div class="col-md-6">
                            <div class="form-group order-transfer-content">
                                <label for=""><b>{{ __('Thông tin thanh toán') }}</b></label>
                                @php
                                $orderTransferContent = implode('', [
                                    'UDBO',
                                    data_get($order, 'id'),
                                ]);

                                $expandedContent = str_replace('${order_transfer_content}', $orderTransferContent, data_get($order->paymentOption, ['expanded_content']));
                                @endphp

                                <p class="p-0 m-0">{!! nl2br($expandedContent) !!}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="k-portlet">
                <div class="k-portlet__head">
                    <div class="k-portlet__head-label">
                        <h3 class="k-portlet__head-title">
                            <i class="flaticon-truck mr-1" style="font-size: 23px; display: inline-block; transform: translateY(2px);"></i>
                            <span>{{ __('Đóng gói và giao hàng') }}</span>
                        </h3>
                    </div>
                </div>
                <div class="k-portlet__body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <span class="d-block mr-2" style="width: 10px; height: 10px; border-radius: 50%; background-color: #5867dd;"></span>
                            <div>
                                <span class="text-primary shipping-referece-id">{{ data_get($order->latestUserOrderShippingHistory, ['reference_id']) ?? 'N/A' }}</span>
                                <span class="copy-text-click ml-2" data-copy-reference=".shipping-referece-id" title="{{ __('Sao chép') }}" style="font-size: 17px; display: inline-block; transform: translateY(2px);">
                                    <i class="flaticon2-copy"></i>
                                </span>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal" data-target="#process_shipping_order">
                                <i class="la la-pencil"></i>
                            </button>
                        </div>
                    </div>
                    <div class="detail-information row">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-start">
                                <div style="flex: 0 0 30%;" class="pt-2 pb-2">Vận chuyển bởi</div>
                                <span class="pt-2 pb-2 mr-2">:</span>
                                <div style="flex: 1;" class="pt-2 bp-2">{{ data_get($order->latestUserOrderShippingHistory, ['shippingProvider', 'name']) }}</div>
                            </div>

                            <div class="d-flex justify-content-start">
                                <div style="flex: 0 0 30%;" class="pt-2 pb-2">P.T vận chuyển</div>
                                <span class="pt-2 pb-2 mr-2">:</span>
                                <div style="flex: 1;" class="pt-2 bp-2">{{ $order->shippingOption->name }}</div>
                            </div>

                            <div class="d-flex justify-content-start">
                                <div style="flex: 0 0 30%;" class="pt-2 pb-2">Khối lượng</div>
                                <span class="pt-2 pb-2 mr-2">:</span>
                                <div style="flex: 1;" class="pt-2 bp-2">{{ $order->total_weight ?? 'N/A' }} <small>(gam)</small> -> {{ (float) $order->total_weight / 1000 }} <small>(kg)</small></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex justify-content-start">
                                <div style="flex: 0 0 30%;" class="pt-2 pb-2">Người trả phí</div>
                                <span class="pt-2 pb-2 mr-2">:</span>
                                <div style="flex: 1;" class="pt-2 bp-2">Shop</div>
                            </div>

                            <div class="d-flex justify-content-start">
                                <div style="flex: 0 0 30%;" class="pt-2 pb-2">Phí ước tính</div>
                                <span class="pt-2 pb-2 mr-2">:</span>
                                <div style="flex: 1;" class="pt-2 bp-2">
                                    <b class="text-danger">{{ format_price(data_get($order->latestUserOrderShippingHistory, ['estimated_transport_fee'])) }}</b>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start">
                                <div style="flex: 0 0 30%;" class="pt-2 pb-2">Phí trả ĐVVC</div>
                                <span class="pt-2 pb-2 mr-2">:</span>
                                <div style="flex: 1;" class="pt-2 bp-2">
                                    <b class="text-danger">{{ $order->transport_fee ? format_price($order->transport_fee) : 'N/A' }}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="k-portlet">
                <div class="k-portlet__head">
                    <div class="k-portlet__head-label">
                        <h3 class="k-portlet__head-title">{{ __('Thông tin đơn hàng') }}</h3>
                    </div>
                </div>
                <div class="k-portlet__body">
                    <div class="d-flex justify-content-start">
                        <div style="flex: 0 0 40%;" class="pt-2 pb-2">Chính sách giá</div>
                        <span class="pt-2 pb-2 mr-2">:</span>
                        <div style="flex: 1;" class="pt-2 bp-2">Giá bán lẻ</div>
                    </div>

                    <div class="d-flex justify-content-start">
                        <div style="flex: 0 0 40%;" class="pt-2 pb-2">Bán tại</div>
                        <span class="pt-2 pb-2 mr-2">:</span>
                        <div style="flex: 1;" class="pt-2 bp-2">Chi nhánh mặc định</div>
                    </div>

                    <div class="d-flex justify-content-start">
                        <div style="flex: 0 0 40%;" class="pt-2 pb-2">NV lên đơn</div>
                        <span class="pt-2 pb-2 mr-2">:</span>
                        <div style="flex: 1;" class="pt-2 bp-2">admin</div>
                    </div>

                    <div class="d-flex justify-content-start">
                        <div style="flex: 0 0 40%;" class="pt-2 pb-2">Ngày bán</div>
                        <span class="pt-2 pb-2 mr-2">:</span>
                        <div style="flex: 1;" class="pt-2 bp-2">{{ format_datetime($order->created_at, 'd/m/Y H:s:i') }}</div>
                    </div>

                    <div class="d-flex justify-content-start">
                        <div style="flex: 0 0 40%;" class="pt-2 pb-2">Kênh bán hàng</div>
                        <span class="pt-2 pb-2 mr-2">:</span>
                        <div style="flex: 1;" class="pt-2 bp-2">{{ enum('AccessChannelType')::findConstantLabel(data_get($order, 'order_channel.type')) }}</div>
                    </div>

                    <div class="d-flex justify-content-start">
                        <div style="flex: 0 0 40%;" class="pt-2 pb-2">Tham chiếu</div>
                        <span class="pt-2 pb-2 mr-2">:</span>
                        <div style="flex: 1;" class="pt-2 bp-2">{{ data_get($order, 'order_channel.reference_id') ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <div class="k-portlet">
                <div class="k-portlet__head">
                    <div class="k-portlet__head-label">
                        <h3 class="k-portlet__head-title">{{ __('Ghi chú') }}</h3>
                    </div>
                </div>
                <div class="k-portlet__body">
                    <div class="form-group">
                        <label for=""><b>{{ __('Khách hàng ghi chú') }}</b></label>
                        <p class="p-0 m-0">{{ $order->user_note ?? 'N/A' }}</p>
                    </div>

                    <div class="form-group">
                        <label for=""><b>{{ __('NV ghi chú') }}</b></label>
                        <p class="p-0 m-0">{{ $order->admin_note ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="k-portlet">
                <div class="k-portlet__head">
                    <div class="k-portlet__head-label">
                        <h3 class="k-portlet__head-title">{{ __('Thông tin sản phẩm') }}</h3>
                    </div>
                </div>
                <div class="k-portlet__body">
                    <table id="table_order_items_index" data-searching="true" data-request-url="{{ route('bo.api.order-items.index', ['order_id' => $order->id]) }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                        <thead>
                            <tr>
                                <th data-property="id">{{ __('ID') }}</th>
                                <th data-orderable="false" data-property="inventory.image" data-render-callback="renderCallbackImage">{{ __('Ảnh') }}</th>
                                <th data-link="inventory.edit" data-link-target="_blank" data-orderable="false" data-property="inventory.title" data-width="400">{{ __('Tên sản phẩm') }}</th>
                                <th data-property="quantity">{{ __('Số lượng') }}</th>
                                <th data-property="price">{{ __('Đơn giá') }}</th>
                                <th data-property="total_price">{{ __('Thành tiền') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@can('orders.manage')
@push('modals')
<div class="modal fade" id="update_order_status_modal" tabindex="-1">
    <div class="modal-dialog">
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

<div class="modal fade" id="process_shipping_order" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="order-update-shipping-form" action="{{ route('bo.api.orders.update-shipping', $order->id) }}" method="PUT">
                <input type="hidden" name="user_order_shipping_history_id" value="{{ $order->latestUserOrderShippingHistory->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Thông tin vận chuyển đơn') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
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
    $(document).on('click', '.copy-text-click', function(e) {
        const referenceId = $(this).attr('data-copy-reference');
        copyToClipboard($(referenceId).text());
        fstoast.success("{{ __('Copied!') }}");
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

    function renderCallbackImage(data) {
        const image = $('<img>', {
            src: data,
            width: 40,
            height: 40,
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
</script>
@endsection
