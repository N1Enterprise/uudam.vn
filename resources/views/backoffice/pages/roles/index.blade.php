@extends('backoffice.layouts.master')

@php
	$title = __('Quyền truy cập');

	$breadcrumbs = [
		[
			'label' => $title,
		]
	];
@endphp

@section('header')
{{ $title }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Danh sách quyền quản trị') }}
                </h3>
            </div>
            @can('roles.store')
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    <a href="{{ route('bo.web.roles.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Tạo quyền quản trị') }}
                    </a>
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            @csrf
            <table data-searching="true" data-request-url="{{ route('bo.api.roles.index') }}" class="datatable table table-striped- table-bordered table-hover table-checkable fs-table-object roleTable" id="k_table_1">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Role') }}</th>
                        <th data-property="users_count">{{ __('Số lượng người dùng') }}</th>
                        <th data-property="created_at">{{ __('Ngày tạo') }}</th>
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
