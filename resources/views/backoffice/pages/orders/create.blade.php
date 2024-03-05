@extends('backoffice.layouts.master')

@php
	$title = __('Thêm đơn hàng');

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
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="row">
		<div class="col-md-12">
            <form class="k-form k-form--label-right" id="form_create_order" method="post" enctype="multipart/form-data">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">1. {{ __('Thông tin khách hàng') }}</h3>
                        </div>
                    </div>

                    <div class="k-portlet__body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>{{ __('Khách hàng') }} *</label>
                                <select data-actions-box="true" name="user_id" title="--{{ __('Chọn khách hàng') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5">
                                    @foreach($users as $user)
                                    <option
                                        data-tokens="{{ (string) $user->name }} | {{ (string) $user->email }} | {{ (string) $user->phone_number ?? 'N/A' }}"
                                        value="{{ $user->id }}">{{ $user->name }} | {{ $user->email }} | {{ $user->phone_number ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">2. {{ __('Thêm giỏ hàng') }}</h3>
                        </div>
                    </div>

                    <div class="k-portlet__body">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <select name="inventory_id" title="--{{ __('Chọn sản phẩm thêm vào giỏ hàng') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5">
                                    @foreach($inventories as $inventory)
                                    <option
                                        value="{{ $inventory->id }}"
                                        data-tokens="{{ $inventory->id }} | {{ $inventory->title }} | {{ $inventory->sku }}"
                                        data-slug="{{ $inventory->slug }}"
                                        data-inventory-id="{{ $inventory->id }}"
                                        data-inventory-name="{{ $inventory->title }}"
                                        data-value='@json($inventory)'
                                    >{{ $inventory->title }} (SKU: {{ $inventory->sku }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <button type="button" class="btn btn-primary btn-block" id="btn_add_to_cart">{{ __('Thêm vào giỏ hàng') }}</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">{{ __('Sản phẩm trong giỏ') }}</div>
                                <table id="items_in_cart_table" class="datatable table table-striped table-bordered table-hover table-checkable">
                                    <thead>
                                        <th>{{ __('STT') }}</th>
                                        <th>{{ __('Ảnh') }}</th>
                                        <th>{{ __('Tên') }}</th>
                                        <th>{{ __('Giá') }}</th>
                                        <th>{{ __('Số lượng') }}</th>
                                        <th>{{ __('Tổng giá') }}</th>
                                        <th>{{ __('Xoá') }}</th>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <th>1</th>
                                            <th>
                                                <img src="https://zcart.incevio.cloud/image/images/6517d665a1297.webp?p=medium" width="50" alt="">
                                            </th>
                                            <th>Veniam facere deleniti est quo nesciunt. - Refurbished</th>
                                            <th>
                                                <input type="number" step="0.01" value="100.12" class="form-control">
                                            </th>
                                            <th>
                                                <input type="number" step="1" value="12" class="form-control">
                                            </th>
                                            <th>
                                                <div>10.000đ</div>
                                            </th>
                                            <th>
                                                <button type="button" class="btn btn-danger btn-icon">
                                                    <i class="flaticon-delete"></i>
                                                </button>
                                            </th>
                                        </tr> --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <b>Tổng cộng</b>
                                            </td>
                                            <td>
                                                <input data-name="total_quantity" type="text" value="" disabled class="form-control">
                                            </td>
                                            <td>
                                                <input data-name="total_price" type="text" value="" disabled class="form-control">
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">3. {{ __('Địa chỉ giao hàng') }}</h3>
                        </div>
                    </div>

                    <div class="k-portlet__body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{ __('Tên khách hàng') }} *</label>
                                <input type="text" class="form-control" name="fullname" placeholder="{{ __('Nhập tên khách hàng') }}" value="">
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('E-mail khách hàng') }} *</label>
                                <input type="text" class="form-control" name="email" placeholder="{{ __('Nhập e-mail khách hàng') }}" value="">
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('SĐT khách hàng') }} *</label>
                                <input type="text" class="form-control" name="phone" placeholder="{{ __('Nhập SĐT khách hàng') }}" value="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{ __('Tên công ty') }}</label>
                                <input type="text" class="form-control" name="company" placeholder="{{ __('Nhập tên công ty') }}" value="">
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('Mã bưu điện') }}</label>
                                <input type="text" class="form-control" name="postal_code" placeholder="{{ __('Nhập mã bưu điện') }}" value="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{ __('Tỉnh/Thành Phố') }} *</label>
                                <select data-actions-box="true" name="province_code" title="--{{ __('Chọn Tỉnh/TP') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5">
                                    @foreach($provinces as $province)
                                    <option
                                        {{ in_array($province->code, old("supported_provinces", [])) ? 'selected' : '' }}
                                        data-tokens="{{ $province->code }} | {{ $province->full_name }}"
                                        data-province-code="{{ $province->code }}"
                                        data-province-name="{{ $province->full_name }}"
                                        value="{{ $province->code }}">{{ $province->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('Quận/Huyện') }} *</label>
                                <select data-actions-box="true" name="district_code" title="--{{ __('Chọn Quận/Huyện') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5" disabled data-districts='@json($districts)'>
                                    {{-- Render --}}
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('Phường/Xã') }} *</label>
                                <select data-actions-box="true" name="ward_code" title="--{{ __('Chọn Phường/Xã') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5" disabled data-wards='@json($wards)'>
                                    {{-- Render --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">4. {{ __('Thông tin vận chuyển') }}</h3>
                        </div>
                    </div>

                    <div class="k-portlet__body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{ __('Tùy chọn vận chuyển') }} *</label>
                                <select name="shipping_option_id" title="--{{ __('Chọn tuỳ chọn vận chuyển') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5" disabled>
                                    {{--  --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">5. {{ __('Thông tin thanh toán') }}</h3>
                        </div>
                    </div>

                    <div class="k-portlet__body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{ __('Tùy chọn thanh toán') }} *</label>
                                <select title="--{{ __('Chọn tùy chọn thanh toán') }}--" name="payment_option_id" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5">
                                    @foreach($paymentOptions as $option)
                                    <option value="{{ $option->id }}" data-tokens="{{ $option->id }} | {{ $option->name }}">{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="k-portlet__foot">
						<div class="k-form__actions">
							<button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
							<button type="redirect" class="btn btn-secondary">{{ __('Huỷ') }}</button>
						</div>
					</div>
                </div>
            </form>
		</div>
	</div>
</div>
@endsection

@section('js_script')
@include('backoffice.pages.orders.js-pages.create')
@endsection
