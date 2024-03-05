@extends('backoffice.layouts.master')

@php
	$title = __('Bài viết');

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
                    {{ __('Danh sách bài viết') }}
                </h3>
            </div>
            @canAny(['posts.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('posts.store')
                    <a href="{{ route('bo.web.posts.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Tạo bài viết') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_posts_index" data-searching="true" data-request-url="{{ route('bo.api.posts.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Tên') }}</th>
                        <th data-property="slug">{{ __('Đường dẫn') }}</th>
                        <th data-orderable="false" data-property="image" data-render-callback="renderCallbackImage">{{ __('Image') }}</th>
                        <th data-property="order">{{ __('Thứ tự') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                        <th data-orderable="false" data-badge data-name="display_on_frontend" data-property="display_on_frontend_name">{{ __('Hiển thị FE') }}</th>
                        <th data-orderable="false" data-badge data-name="allow_frontend_search" data-property="allow_frontend_search_name">{{ __('FE Search') }}</th>
                        <th data-orderable="false" data-property="post_category.name">{{ __('Danh mục') }}</th>
                        <th data-orderable="false" data-property="created_by.name">{{ __('Ngày tạo') }}</th>
                        <th data-orderable="false" data-property="updated_by.name">{{ __('Ngày cập nhật') }}</th>
                        <th data-property="post_at">{{ __('Viết lúc') }}</th>
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
