@extends('backoffice.layouts.master')

@php
	$title = __('Order');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Edit Order'),
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
        case enum('OrderStatusEnum')::DELIVERY:
            $orderStatusClass = 'badge badge-primary';
            break;
        case enum('OrderStatusEnum')::COMPLETED:
            $orderStatusClass = 'badge badge-success';
            break;
        case enum('OrderStatusEnum')::CANCELED:
        case enum('OrderStatusEnum')::REFUNDED:
            $orderStatusClass = 'badge badge-danger';
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
                            <span>{{ __('Order') }}</span>
                            <b>#{{ $order->order_code }}</b>
                        </h3>

                        <div data-toggle="tooltip" data-title="{{ __('Order Status') }}" class="order_status {{ $orderStatusClass }}" style="margin-left: 10px; text-transform: uppercase;">{{ $order->order_status_name }} {{ __('Order') }}</div>

                        <span style="padding: 0 10px;">|</span>

                        <div data-toggle="tooltip" data-title="{{ __('Payment Status') }}" class="order_status {{ $paymentStatusClass }}" style="text-transform: uppercase;">{{ $order->payment_status_name }} {{ __('Payment') }}</div>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#order_tab" role="tab" aria-selected="true">
									{{ __('Order') }}
								</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#address_shipping_tab" role="tab" aria-selected="true">
									{{ __('Address Shipping') }}
								</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#delivery_tab" role="tab" aria-selected="true">
									{{ __('Delivery') }}
								</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#payment_tab" role="tab" aria-selected="true">
									{{ __('Payment') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

                <div class="k-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="order_tab" role="tabpanel">
                            <div class="user_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#1. GENERAL INFORMATION</h5>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Order Code') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->order_code }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('UUID') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->uuid }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label><a href="{{ route('bo.web.users.edit', $order->user->id) }}" target="_bank">User ID</a></label>
                                        <input type="text" class="form-control" value="{{ $order->user->id }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('User Name') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->user->name }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Total Item') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->total_item }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Total Quantity') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->total_quantity }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Taxrate') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->taxrate }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Shipping Weight') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->shipping_weight }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Total Price') }}</label>
                                        <input type="text" class="form-control" value="{{ format_price($order->total_price) }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Grand Total') }}</label>
                                        <input type="text" class="form-control" value="{{ format_price($order->grand_total) }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('User Note') }}</label>
                                        <textarea cols="20" rows="3" class="form-control" disabled>{{ $order->user_note }}</textarea>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Admin Note') }}</label>
                                        <textarea cols="20" rows="3" class="form-control" disabled>{{ $order->admin_note }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="order-items">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#2. {{ __('ORDER ITEMS') }}</h5>
                                <table id="table_order_items_index" data-searching="true" data-request-url="{{ route('bo.api.order-items.index', ['order_id' => $order->id]) }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                                    <thead>
                                        <tr>
                                            <th data-property="id">{{ __('ID') }}</th>
                                            <th data-orderable="false" data-property="inventory.image" data-render-callback="renderCallbackImage">{{ __('Image') }}</th>
                                            <th data-link="inventory.edit" data-link-target="_blank" data-orderable="false" data-property="inventory.title" data-render-callback="renderCallbackImage">{{ __('Name') }}</th>
                                            <th data-property="currency_code">{{ __('Currency Code') }}</th>
                                            <th data-property="quantity">{{ __('Quantity') }}</th>
                                            <th data-property="price">{{ __('Price') }}</th>
                                            <th data-property="total_price">{{ __('Total Price') }}</th>
                                            <th data-property="created_at">{{ __('Created At') }}</th>
                                            <th data-property="updated_at">{{ __('Updated At') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="address_shipping_tab" role="tabpanel">
                            <div class="address_shipping_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#3. {{ __('ADDRESS SHIPPING') }}</h5>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Full Name') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->fullname }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('E-mail') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->email }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Phone Number') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->phone }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Company') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->company }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Country Code') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->country_code }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Address Line') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->address_line }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('City Name') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->city_name }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Postal Code') }}</label>
                                        <input type="text" class="form-control" value="{{ $order->postal_code }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="delivery_tab" role="tabpanel">
                            <div class="delivery_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#4. DELIVERY INFORMATION</h5>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>
                                            <a href="{{ route('bo.web.shipping-rates.edit', $order->shippingRate->id) }}" target="_blank">{{ __('Shipping Rate') }}</a>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $order->shippingRate->name }} ({{ format_price($order->shippingRate->rate) }})" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>
                                            <a href="{{ route('bo.web.carriers.edit', $order->shippingRate->carrier->id) }}" target="_blank">{{ __('Carrier') }}</a>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $order->shippingRate->carrier->name }}" disabled>
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
                        <button class="btn btn-secondary mr-2" data-toggle="modal" data-target="#change_payment_status" {{ !$order->canChangePaymentStatus() ? 'disabled' : '' }}>{{ __('Change Payment Status') }}</button>

                        <button class="btn btn-info mr-2" data-toggle="modal" data-target="#change_order_status" {{ !$order->canChangeOrderStatus() ? 'disabled' : '' }}>{{ __('Change Order Status') }}</button>

                        <form action="{{ route('bo.api.orders.change-status', $order->id) }}" data-form="change_status" method="POST" class="mr-2" data-confirmation="{{ __('Are you sure to complete this order?') }}" data-msg-success="{{ __('Complete order success.') }}" data-msg-error="{{ __('Complete order error.') }}">
                            <input type="hidden" name="order_status" value="{{ enum('OrderStatusEnum')::COMPLETED }}">
                            <button type="submit" class="btn btn-success" {{ !$order->canChangeOrderStatus() ? 'disabled' : '' }}>{{ __('Complete Order') }}</button>
                        </form>

                        <form action="{{ route('bo.api.orders.change-status', $order->id) }}" data-form="change_status" method="POST" data-confirmation="{{ __('Are you sure to cancel this order?') }}" data-msg-success="{{ __('Cancen order success.') }}" data-msg-error="{{ __('Cancen order error.') }}">
                            <input type="hidden" name="order_status" value="{{ enum('OrderStatusEnum')::CANCELED }}">
                            <button type="submit" class="btn btn-danger" {{ !$order->canChangeOrderStatus() ? 'disabled' : '' }}>{{ __('Cancel Order') }}</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection

@push('modals')
@can('orders.manage')
<div class="modal fade" id="change_order_status" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form action="{{ route('bo.api.orders.change-status', $order->id) }}" data-form="change_status" method="POST" data-msg-success="{{ __('Change payment status success.') }}" data-msg-error="{{ __('Change payment status error.') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Change Order Status') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ __('Order Status') }}</label>
                        <select name="order_status" id="" class="form-control k_selectpicker" data-live-search="true" data-size="5">
                            @foreach ($orderStatusEnumLabels as $key => $label)
                            <option value="{{ $key }}" {{ $order->order_status == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="admin_note">{{ __('Admin Note') }}</label>
                        <textarea name="admin_note" id="admin_note" rows="4" class="form-control">{{ $order->admin_note }}</textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcan

@can('orders.manage')
<div class="modal fade" id="change_payment_status" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form action="{{ route('bo.api.orders.change-status', $order->id) }}" data-form="change_status" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Change Payment Status') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ __('Payment Status') }}</label>
                        <select name="payment_status" class="form-control k_selectpicker" data-live-search="true" data-size="5">
                            @foreach ($paymentStatusEnumLabels as $key => $label)
                            <option value="{{ $key }}" {{ $order->payment_status == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="admin_note">{{ __('Admin Note') }}</label>
                        <textarea name="admin_note" id="admin_note" rows="4" class="form-control">{{ $order->admin_note }}</textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcan
@endpush

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
</script>
@include('backoffice.pages.orders.js-pages.edit')
@endsection
