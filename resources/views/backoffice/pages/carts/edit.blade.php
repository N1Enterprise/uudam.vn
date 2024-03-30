@extends('backoffice.layouts.master')

@php
	$title = __('Thông tin giỏ hàng');

	$breadcrumbs = [
		[
			'label' => __('Giỏ hàng'),
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
                            <span>{{ __('Giỏ hàng') }} ({{ $cart->currency_code }})</span>
                        </h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#order_tab">
									{{ __('Thông tin chung') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

                <div class="k-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="order_tab">
                            <div class="user_information">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#1. {{ __('Thông tin chung') }}</h5>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <a href="{{ route('bo.web.users.edit', data_get($cart, 'user.id')) }}" target="_blank">{{ __('Khách hàng') }}</a>
                                        </label>
                                        <input type="text" class="form-control" value="({{ data_get($cart, 'user.id') }}) {{ data_get($cart, 'user.name') }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('UUID') }}</label>
                                        <input type="text" class="form-control" value="{{ $cart->uuid }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{ __('Địa chỉ IP') }}</label>
                                        <input type="text" class="form-control" value="{{ $cart->ip_address }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Tổng số mặt hàng thực tế') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Bao gồm tất cả các trạng thái') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ count($cart->cartItems) }}" disabled>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Tổng số lượng thực tế') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Bao gồm tất cả các trạng thái') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $cart->cartItems->sum('quantity') }}" disabled>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Tổng giá thực tế') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Bao gồm tất cả các trạng thái') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ format_price($cart->cartItems->sum('price')) }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Tổng số mặt hàng') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Chỉ tính tổng số mặt hàng ở trạng thái chờ xử lý') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $cart->total_item }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Tổng số lượng') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Chỉ tính tổng số mặt hàng ở trạng thái chờ xử lý') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $cart->total_quantity }}" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            {{ __('Tổng giá') }}
                                            <i data-toggle="tooltip" data-title="{{ __('Chỉ tính tổng số mặt hàng ở trạng thái chờ xử lý') }}" class="flaticon-questions-circular-button"></i>
                                        </label>
                                        <input type="text" class="form-control" value="{{ format_price($cart->total_price) }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="order-items">
                                <h5 style="margin-bottom: 30px; font-weight: bold;">#2. {{ __('Sản phẩm trong giỏ') }}</h5>
                                <table id="table_carts_items_index" data-searching="true" data-request-url="{{ route('bo.api.cart-items.index', ['cart_id' => $cart->id]) }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                                    <thead>
                                        <tr>
                                            <th data-property="id">{{ __('ID') }}</th>
                                            <th data-orderable="false" data-property="inventory.image" data-render-callback="renderCallbackImage">{{ __('Hình ảnh') }}</th>
                                            <th data-link="inventory.edit" data-link-target="_blank" data-orderable="false" data-property="inventory.title" data-render-callback="renderCallbackImage">{{ __('Tên') }}</th>
                                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                                            <th data-property="currency_code">{{ __('Tiền tệ') }}</th>
                                            <th data-property="quantity">{{ __('Số lượng') }}</th>
                                            <th data-property="price">{{ __('Giá') }}</th>
                                            <th data-property="total_price">{{ __('Tổng giá') }}</th>
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
