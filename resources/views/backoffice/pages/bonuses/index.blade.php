@extends('backoffice.layouts.master')

@php
	$title = __('Bonuses');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => 'Manage',
		]
	];
@endphp

@section('header')
{{ $title }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    @include('backoffice.partials.message')

    <div class="k-portlet">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">{{ __('Search') }}</h3>
            </div>
        </div>

        <!--begin::Form-->
        <form class="k-form k-form--label-right" data-datatable="bonusTable" id="index_search_bonus_table" method="GET">
            <div class="k-portlet__body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>{{ __('Bonus Code') }}</label>
                        <input type="text" class="form-control" name="code">
                    </div>
                    <div class="col-lg-4">
                        <label>{{ __('Bonus Name') }}</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-lg-4">
                        <label>{{ __('Promo Code') }}</label>
                        <input type="text" class="form-control" name="promotion_code">
                    </div>
                </div>
            </div>

            <div class="k-portlet__foot">
                <div class="k-form__actions">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>

    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Bonus List') }}
                </h3>
            </div>
            @can('bonuses.modify')
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    <a href="{{ route('bo.web.bonuses.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create New Bonus') }}
                    </a>
                </div>
            </div>
            @endcan
        </div>

        <div class="k-portlet__body">
            <table id="index_bonus_table" data-searching="true" data-request-url="{{ route('bo.api.bonuses.index') }}" class="datatable table table-striped- table-bordered table-hover table-checkable fs-table-object roleTable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Name') }}</th>
                        <th data-property="code">{{ __('Code') }}</th>
                        <th data-orderable="false" data-render-callback="renderStatusCallback" data-name="status" data-property="status_name">{{ __('Status') }}</th>
                        <th data-name="category" data-property="category_name">{{ __('Category') }}</th>
                        <th data-orderable="false" data-property="awarding_type_name">{{ __('Award Type') }}</th>
                        <th data-property="start_at">{{ __('Start Date') }}</th>
                        <th data-property="end_at">{{ __('End Date') }}</th>
                        <th data-property="created_at">{{ __('Created At') }}</th>
                        <th data-orderable="false" data-property="created_by.display">{{ __('Created By') }}</th>
                        <th data-property="updated_at">{{ __('Updated At') }}</th>
                        <th data-orderable="false" data-property="updated_by.display">{{ __('Updated By') }}</th>
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
@include('backoffice.pages.bonuses.js-pages.index-script')
@endsection
