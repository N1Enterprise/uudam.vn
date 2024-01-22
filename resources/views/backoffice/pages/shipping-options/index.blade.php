@extends('backoffice.layouts.master')

@php
	$title = __('Shipping Options');

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
                    {{ __('Shipping Option') }}
                </h3>
            </div>
            @canAny(['shipping-options.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('shipping-options.store')
                    <a href="{{ route('bo.web.shipping-options.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Shipping Option') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_shipping_options_index" data-searching="true" data-request-url="{{ route('bo.api.shipping-options.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-orderable="false" data-property="logo" data-render-callback="renderLogoImage">{{ __('Logo') }}</th>
                        <th data-property="name">{{ __('Name') }}</th>
                        <th data-property="order">{{ __('Order') }}</th>
                        <th data-badge data-name="type" data-property="type_name">{{ __('Type') }}</th>
                        <th data-orderable="false" data-property="shipping_provider.name" data-link-target="_blank" data-link="shipping_provider.actions.update">{{ __('Provider') }}</th>
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
    function renderLogoImage(data, type, full) {
        const image = $('<img>', {
            src: data,
            width: 80,
            height: 80,
        });

        return image.prop('outerHTML');
    }
</script>
@endsection
