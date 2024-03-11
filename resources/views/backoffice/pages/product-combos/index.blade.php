@extends('backoffice.layouts.master')

@php
	$title = __('Product Combo');

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
    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Product Combo') }}
                </h3>
            </div>
            @canAny(['product-combos.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('product-combos.store')
                    <a href="{{ route('bo.web.product-combos.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Product Combo') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_included_products_index" data-searching="true" data-request-url="{{ route('bo.api.product-combos.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Tên') }}</th>
                        <th data-orderable="false" data-property="image" data-render-callback="renderCallbackImage">{{ __('Image') }}</th>
                        <th data-property="sale_price">{{ __('Sale Price') }}</th>
                        <th data-property="stock_quantity">{{ __('Stock Quantity') }}</th>
                        <th data-property="unit">{{ __('Unit') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
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
    function renderCallbackImage(data, type, full) {
        const image = $('<img>', {
            src: data,
            width: 80,
            height: 80,
        });

        return image.prop('outerHTML');
    }
</script>
@endsection
