@extends('backoffice.layouts.master')

@php
	$title = 'Admin Manage';

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
                    {{ __('Admins') }}
                </h3>
            </div>
            @canAny(['admins.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('admins.store')
                    <a href="{{ route('bo.web.admins.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Admin') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_roles_index" data-searching="true" data-request-url="{{ route('bo.api.admins.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="email">{{ __('Email') }}</th>
                        <th data-property="name">{{ __('Name') }}</th>
                        <th data-orderable="false" data-property="role" data-render-callback="tableCallbackFnRenderRole">{{ __('Role_Label') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                        <th data-property="created_at">{{ __('Created At') }}</th>
                        <th data-property="last_login_at">{{ __('Last Login At') }}</th>
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
@include('backoffice.pages.admins.js-pages.index-script')
@endsection

