@extends('backoffice.layouts.master')

@canany(['reports.view-new-users', 'reports.view-new-orders', 'reports.view-turnover', 'reports.view-top-users'])
@section('header')
Tổng Quan
@endsection

@section('breadcrumb')
<form  class="flex-container" id="form_dashboard_filter" name="search_player_form" method="GET">
    <div class="k-content__filter_item">
        <div class="input-group daterangepickers dateRangeFilter" style="min-width: 400px" custom-range="true" date-range-time="false" date-predefined="true" id="dateRangePickerHeader">
            <input id="inputDateRangePicker" type="text" value="{{ __('Today') }}" class="form-control " readonly="" placeholder="{{ __('Select date range') }}">
            <div class="input-group-append">
                <span class="input-group-text btn  btn-icon  btn-elevate btn-brand"><i class="flaticon-calendar-with-a-clock-time-tools"></i></span>
            </div>
            <input type="hidden" id="startDate" data-daterangepicker-catch="start" value="{{ now()->addMinutes(getUtcOffset())->startOfDay()->toDateTimeString() }}" name="date_range[]">
            <input type="hidden" id="endDate" data-daterangepicker-catch="end" value="{{ now()->addMinutes(getUtcOffset())->endOfDay()->toDateTimeString() }}" name="date_range[]">
        </div>
    </div>
</form>
@endsection

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <div class="row">
        @can('reports.view-new-users')
        @include('backoffice.pages.dashboard.partials.statistic-user')
        @endcan

        @can('reports.view-new-orders')
        @include('backoffice.pages.dashboard.partials.statistic-order')
        @endcan

        @can('reports.view-turnover')
        @include('backoffice.pages.dashboard.partials.statistic-deposit')
        @endcan
    </div>

    @can('reports.view-top-users')
    <div class="row">
        @include('backoffice.pages.dashboard.partials.table-top-user')
    </div>
    @endcan
</div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
@include('backoffice.pages.dashboard.js-pages.index')
@endsection
@endcanany
