@extends('backoffice.layouts.master')

@php
    $title = 'Users';

    $breadcrumbs = [
        [
            'label' => $title,
        ],
        [
            'label' => 'User Manage',
        ],
    ];

    $filters = [
        [
            'name'  => 'payload',
            'type'  => 'text',
            'label' => __('Payload'),
        ],
        [
            'name'  => 'uuid',
            'type'  => 'text',
            'label' => __('UUID'),
        ],
    ]
@endphp

@section('header')
{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <div class="k-portlet">
        <!--begin::Form-->
        <form data-datatable="table_list_user" class="k-form k-form--label-right" id="search_user_form" name="search_user_form" method="GET">
            <div class="k-portlet__body">
                <div class="filter_body">
                    <div class="row filter_content">
                        <div class="col-lg-3 form-group">
                            <div class="input-group pull-right">
                                <input type="daterangepicker" placeholder="{{ __('Registration Date') }}" class="form-control" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                                <input type="hidden" data-daterangepicker-catch="start" name="created_at_range[]">
                                <input type="hidden" data-daterangepicker-catch="end" name="created_at_range[]">
                            </div>
                        </div>
                        <div class="col-lg-3 form-group">
                            <x-search-username-input placeholder="{{ __('User Username') }}" />
                        </div>
                        <div class="col-lg-3 form-group">
                            <input type="text" class="form-control" data-original-title="{{ __('User Email') }}" data-toggle="tooltip" placeholder="{{ __('User Email') }}" name="email" id="email">
                        </div>
                        <div class="col-lg-3 form-group">
                            <input type="text" data-original-title="{{ __('First Name') }}" data-toggle="tooltip" class="form-control" placeholder="{{ __('First Name') }}" name="first_name" id="first_name">
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="text" data-original-title="{{ __('Last Name') }}" data-toggle="tooltip" class="form-control" placeholder="{{ __('Last Name') }}" name="last_name" id="last_name">
                        </div>

                        <div class="form-group col-lg-3">
                            <x-phone-input placeholder="{{ __('Phone Number') }}" class="form-control" />
                        </div>

                        <div class="form-group col-lg-3"  data-original-title="{{ __('Status') }}" data-toggle="tooltip">
                            <select name="status " class="form-control k_selectpicker" aria-placeholder="{{ __('Status') }}">
                                <option value="">--{{ __('Select Status') }}--</option>
                                @foreach($userStatus as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row filter_place_content"></div>
                    @component('backoffice.partials.filter', ['items' => $filters,'tableName'=>'index_deposit_transaction_table']) @endcomponent
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Search') }}</button>
                        <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
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
                    {{ __('Users Manage') }}
                </h3>
            </div>
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    {{-- @can('users.export')
                    <x-exporter export-url="{{route('bo.api.users.export.csv')}}" exporter="users" datatable="#table_list_user" />
                    @endcan --}}
                </div>
            </div>
        </div>
        <div class="k-portlet__body">
            <!--begin: Datatable -->
            <table data-searching="true" data-request-url="{{ route('bo.api.users.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object" id="table_list_user">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('User ID') }}</th>
                        <th data-property="username">{{ __('User Username') }}</th>
                        <th data-name="status" data-badge data-property="serialized_status_name">{{ __('Status') }}</th>
                        <th data-orderable="false" data-property="userDetail.first_name">{{ __('First Name') }}</th>
                        <th data-orderable="false" data-property="userDetail.last_name">{{ __('Last Name') }}</th>
                        <th data-name="currency_code" data-property="currency.code">{{ __('Currency') }}</th>
                        <th data-property="email">{{ __('Email') }}</th>
                        <th data-name="phone_number" data-property="phone_number_beautify">{{ __('Phone Number') }}</th>
                        <th data-property="created_at">{{ __('Signup Date') }}</th>
                        <th data-name="platform" data-property="platform_name">{{ __('Platform') }}</th>
                        <th class="datatable-action" data-property="actions">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>
</div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script src="{{ asset('backoffice/js/common/fs_date_range_picker.js') }}?v={{ config('parameter.static_version') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        fsDateRangePicker.init();
    })

    function renderKycStatus(data, type, full, meta) {
        let renderValue = data;
        if (! renderValue) {
            renderValue = 'neutral';
        }

        return $('<div>').append(generateBadgeElement(renderValue, null, data)).html();
    }

</script>
@endsection
