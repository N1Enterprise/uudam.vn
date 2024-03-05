@extends('backoffice.layouts.master')

@php
	$title = __('Collection');

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
                    {{ __('Collection') }}
                </h3>
            </div>
            @canAny(['collections.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('collections.store')
                    <a href="{{ route('bo.web.collections.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Collection') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_collections_index" data-searching="true" data-request-url="{{ route('bo.api.collections.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Tên') }}</th>
                        <th data-orderable="false" data-property="primary_image" data-render-callback="renderCallbackImage">{{ __('Primary Image') }}</th>
                        <th data-orderable="false" data-property="cover_image" data-render-callback="renderCallbackImage">{{ __('Cover Image') }}</th>
                        <th data-property="cta_label">{{ __('Cta Label') }}</th>
                        <th data-property="order">{{ __('Order') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                        <th data-orderable="false" data-badge data-name="display_on_frontend" data-property="display_on_frontend_name">{{ __('FE Display') }}</th>
                        <th data-orderable="false" data-badge data-name="allow_frontend_search" data-property="allow_frontend_search_name">{{ __('FE Search') }}</th>
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
