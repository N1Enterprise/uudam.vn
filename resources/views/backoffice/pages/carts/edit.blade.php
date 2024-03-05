@extends('backoffice.layouts.master')

@php
	$title = __('Carts');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Edit Cart'),
		]
	];
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
                            <span>{{ __('Cart') }} ({{ $cart->currency_code }})</span>
                        </h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#order_tab" role="tab" aria-selected="true">
									{{ __('General Information') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

                <div class="k-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="order_tab" role="tabpanel">
                            <div class="user_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#1. {{ __('GENERAL INFORMATION') }}</h5>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <a href="{{ route('bo.web.users.edit', data_get($cart, 'user.id')) }}" target="_blank">{{ __('User Username') }}</a>
                                        </label>
                                        <input type="text" class="form-control" value="({{ data_get($cart, 'user.id') }}) {{ data_get($cart, 'user.name') }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('UUID') }}</label>
                                        <input type="text" class="form-control" value="{{ $cart->uuid }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Ip Address') }}</label>
                                        <input type="text" class="form-control" value="{{ $cart->ip_address }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Actual Total Items') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Includes all statuses') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ count($cart->cartItems) }}" disabled>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Actual Total Quantity') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Includes all statuses') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $cart->cartItems->sum('quantity') }}" disabled>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Actual Total Price') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Includes all statuses') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ format_price($cart->cartItems->sum('price')) }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Total Item') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Only calculate the total of items in pending status') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $cart->total_item }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Total Quantity') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Only calculate the total of items in pending status') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $cart->total_quantity }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Total Price') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Only calculate the total of items in pending status') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ format_price($cart->total_price) }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="order-items">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#2. {{ __('CART ITEMS') }}</h5>
                                <table id="table_carts_items_index" data-searching="true" data-request-url="{{ route('bo.api.cart-items.index', ['cart_id' => $cart->id]) }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                                    <thead>
                                        <tr>
                                            <th data-property="id">{{ __('ID') }}</th>
                                            <th data-orderable="false" data-property="inventory.image" data-render-callback="renderCallbackImage">{{ __('Image') }}</th>
                                            <th data-link="inventory.edit" data-link-target="_blank" data-orderable="false" data-property="inventory.title" data-render-callback="renderCallbackImage">{{ __('Tên') }}</th>
                                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
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
@include('backoffice.pages.orders.js-pages.edit')
@endsection
