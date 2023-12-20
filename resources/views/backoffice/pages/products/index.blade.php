@extends('backoffice.layouts.master')

@php
	$title = __('Product');

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
                    {{ __('Product') }}
                </h3>
            </div>
            @canAny(['products.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('products.store')
                    <a href="{{ route('bo.web.products.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Product') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_category_groups_index" data-searching="true" data-request-url="{{ route('bo.api.products.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Name') }}</th>
                        <th data-orderable="false" data-property="primary_image" data-render-callback="renderCallbackPrimaryImage">{{ __('Primary Image') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                        <th data-name="type" data-property="type_name">{{ __('Product Type') }}</th>
                        <th data-property="code">{{ __('Code') }}</th>
                        <th data-property="slug">{{ __('Slug') }}</th>
                        <th data-property="branch">{{ __('Branch') }}</th>
                        <th data-orderable="false" data-property="created_by.name">{{ __('Created By') }}</th>
                        <th data-orderable="false" data-property="updated_by.name">{{ __('Updated By') }}</th>
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
    function renderCallbackPrimaryImage(data, type, full) {
        const image = $('<img>', {
            src: data,
            width: 80,
            height: 80,
        });

        return image.prop('outerHTML');
    }
</script>
@endsection
