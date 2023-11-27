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

    $statusClsas = 'badge badge-success';

    switch ($order->order_status) {
        case enum('OrderStatusEnum')::WAITING_FOR_PAYMENT:
            $statusClsas = 'badge badge-secondary';
            break;
        case enum('OrderStatusEnum')::PAYMENT_ERROR:
            $statusClass = 'badge badge-warning';
            break;
        case enum('OrderStatusEnum')::PROCESSING:
        case enum('OrderStatusEnum')::DELIVERY:
            $statusClass = 'badge badge-primary';
            break;
        case enum('OrderStatusEnum')::COMPLETED:
            $statusClass = 'badge badge-success';
            break;
        case enum('OrderStatusEnum')::CANCELED:
        case enum('OrderStatusEnum')::REFUNDED:
            $statusClass = 'badge badge-danger';
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
                        <div class="order_status {{ $statusClsas }}" style="margin-left: 10px; text-transform: uppercase;">{{ $order->order_status_name }}</div>
                        <span style="padding: 0 10px;">|</span>
                        <div class="" style="margin-left: 10px; text-transform: uppercase; display: flex; align-items: center;">
                            <img src="{{ $order->paymentOption->logo }}" alt="{{ $order->paymentOption->name }}" width="40" height="40">
                            <span class="ml-2 mt-1">{{ $order->paymentOption->name }}</span>
                        </div>
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
                                        <label for="uuid">Order Code</label>
                                        <input type="text" class="form-control" value="{{ $order->order_code }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">UUID</label>
                                        <input type="text" class="form-control" value="{{ $order->uuid }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="uuid"><a href="{{ route('bo.web.users.edit', $order->user->id) }}" target="_bank">User ID</a></label>
                                        <input type="text" class="form-control" value="{{ $order->user->id }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">User Name</label>
                                        <input type="text" class="form-control" value="{{ $order->user->name }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Total Item</label>
                                        <input type="text" class="form-control" value="{{ $order->total_item }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Total Quantity</label>
                                        <input type="text" class="form-control" value="{{ $order->total_quantity }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Taxrate</label>
                                        <input type="text" class="form-control" value="{{ $order->taxrate }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Shipping Weight</label>
                                        <input type="text" class="form-control" value="{{ $order->shipping_weight }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Total Price</label>
                                        <input type="text" class="form-control" value="{{ format_price($order->total_price) }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Grand Total</label>
                                        <input type="text" class="form-control" value="{{ format_price($order->grand_total) }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="order-items">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#2. ORDER ITEMS</h5>
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
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#3. ADDRESS SHIPPING</h5>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Full Name</label>
                                        <input type="text" class="form-control" value="{{ $order->fullname }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">E-mail</label>
                                        <input type="text" class="form-control" value="{{ $order->email }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Phone Number</label>
                                        <input type="text" class="form-control" value="{{ $order->phone }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Company</label>
                                        <input type="text" class="form-control" value="{{ $order->company }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Country Code</label>
                                        <input type="text" class="form-control" value="{{ $order->country_code }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Address Line</label>
                                        <input type="text" class="form-control" value="{{ $order->address_line }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">City Name</label>
                                        <input type="text" class="form-control" value="{{ $order->city_name }}" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">Postal Code</label>
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
                                        <label for="uuid">
                                            <a href="{{ route('bo.web.shipping-rates.edit', $order->shippingRate->id) }}" target="_blank">{{ __('Shipping Rate') }}</a>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $order->shippingRate->name }} ({{ format_price($order->shippingRate->rate) }})" disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uuid">
                                            <a href="{{ route('bo.web.carriers.edit', $order->shippingRate->carrier->id) }}" target="_blank">{{ __('Carrier') }}</a>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $order->shippingRate->carrier->name }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="payment_tab" role="tabpanel">
                            <div class="payment_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#5. PAYMENT INFORMATION</h5>

                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection

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
@endsection
