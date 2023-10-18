@extends('backoffice.layouts.master')

@php
	$title = __('Included Product');

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
        @include('backoffice.partials.message')
        <div class="k-portlet k-portlet--mobile">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">
                        {{ __('Included Product') }}
                    </h3>
                </div>
                @canAny(['included-products.store'])
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        @can('included-products.store')
                        <a href="{{ route('bo.web.included-products.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                            <i class="la la-plus"></i>
                            {{ __('Create Included Product') }}
                        </a>
                        @endcan
                    </div>
                </div>
                @endcan
            </div>
            <div class="k-portlet__body">
                <table id="table_included_products_index" data-searching="true" data-request-url="{{ route('bo.api.included-products.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-property="name">{{ __('Name') }}</th>
                            <th data-orderable="false" data-property="image" data-render-callback="renderCallbackImage">{{ __('Image') }}</th>
                            <th data-property="sale_price">{{ __('Sale Price') }}</th>
                            <th data-property="stock_quantity">{{ __('Stock Quantity') }}</th>
                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                            <th data-property="created_at">{{ __('Created At') }}</th>
                            <th data-property="updated_at">{{ __('Updated At') }}</th>
                            <th class="datatable-action" data-property="actions">{{ __('Action') }}</th>
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
