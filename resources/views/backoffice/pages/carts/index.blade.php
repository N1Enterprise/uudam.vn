@extends('backoffice.layouts.master')

@php
	$title = __('Giỏ hàng');

	$breadcrumbs = [
		[
			'label' => $title,
		]
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
    <div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">

        @include('backoffice.pages.carts.partials.search-form')

        <div class="k-portlet k-portlet--mobile">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">
                        {{ __('Danh sách giỏ hàng') }}
                    </h3>
                </div>
            </div>
            <div class="k-portlet__body">
                <table id="table_carts_index" data-searching="true" data-request-url="{{ route('bo.api.carts.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-orderable="false" data-property="user.name" data-link="user.edit_link" data-link-target="_blank">{{ __('Tên khách hàng') }}</th>
                            <th data-orderable="false" data-property="order.order_code" data-render-callback="renderCallbackOrder">{{ __('Mã đơn hàng') }}</th>
                            <th data-property="ip_address">{{ __('Địa chỉ IP') }}</th>
                            <th data-property="total_item">{{ __('Số lượng SP') }}</th>
                            <th data-property="total_quantity">{{ __('Tổng số lượng') }}</th>
                            <th data-property="total_price">{{ __('Tổng giá') }}</th>
                            <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                            <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
                            <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script>
    function renderCallbackOrder(data, type, full) {
        const dom = $('<div class="text-center">');

        if (full?.order?.edit_link) {
            dom.append(`<a href="${full?.order?.edit_link}" target="_blank" class="mb-2 d-block">${data || 'N/A'}</a>`)
        } else {
            dom.append(`<span>N/A</span>`);
        }

        if (full?.order?.order_status_name) {
            dom.append(`<small class="d-block">(${full?.order?.order_status_name})</small>`);
        }

        return dom.prop('outerHTML');
    }
</script>
@endsection
