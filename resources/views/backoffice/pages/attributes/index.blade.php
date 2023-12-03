@extends('backoffice.layouts.master')

@php
	$title = __('Attribute');

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
                    {{ __('Attribute') }}
                </h3>
            </div>
            @canAny(['attributes.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('attributes.store')
                    <a href="{{ route('bo.web.attributes.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Attribute') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_attributes_index" data-searching="true" data-request-url="{{ route('bo.api.attributes.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Name') }}</th>
                        <th data-property="order">{{ __('Order') }}</th>
                        <th data-orderable="false" data-name="attribute_type" data-property="attribute_type_name">{{ __('Attribute Type') }}</th>
                        <th data-orderable="false" data-property="categories" data-render-callback="renderCallbackCategories">{{ __('Categories') }}</th>
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
    function renderCallbackCategories(data, type, full) {
        const count = data?.length || 0;

        if (! count) {
            return;
        }

        const categoriesBadge = data.map((category, index) => {
            return $('<span>', { class: `mr-1 mt-1` })
                    .append(`<span class="k-badge k-badge--brand k-badge--inline k-badge--outline k-badge--pill">${data_get(category, 'name')}</span>`).prop('outerHTML');
        });

        const container = $('<div>', { class: 'category-see-more' }).append(categoriesBadge.join(''));

        return container.prop('outerHTML');
    }
</script>
@endsection
