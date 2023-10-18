@extends('backoffice.layouts.master')

@php
	$title = __('Pages');

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
                        {{ __('Pages') }}
                    </h3>
                </div>
                @canAny(['pages.store'])
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        @can('pages.store')
                        <a href="{{ route('bo.web.pages.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                            <i class="la la-plus"></i>
                            {{ __('Create Pages') }}
                        </a>
                        @endcan
                    </div>
                </div>
                @endcan
            </div>
            <div class="k-portlet__body">
                <table id="table_pages_index" data-searching="true" data-request-url="{{ route('bo.api.pages.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-property="name">{{ __('Name') }}</th>
                            <th data-property="slug">{{ __('Slug') }}</th>
                            <th data-property="title">{{ __('Title') }}</th>
                            <th data-property="order">{{ __('Order') }}</th>
                            <th data-orderable="false" data-badge data-name="display_type" data-property="display_type_name">{{ __('Display Type') }}</th>
                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                            <th data-orderable="false" data-badge data-name="has_contact_form" data-property="has_contact_form_name">{{ __('Has Contact Form') }}</th>
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
