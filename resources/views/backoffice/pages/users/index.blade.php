@extends('backoffice.layouts.master')

@php
    $title = __('Danh sách khách hàng');

    $breadcrumbs = [
        [
            'label' => __('Khách Hàng'),
        ],
        [
            'label' => $title,
        ],
    ];
@endphp

@section('header')
{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <div class="k-portlet">
        <!--begin::Form-->
        <form data-datatable="table_user-list-index" class="k-form k-form--label-right" id="search_user_form" name="search_user_form" method="GET">
            <div class="k-portlet__body">
                <div class="filter_body">
                    <div class="row filter_content">
                        <div class="col-lg-3 form-group">
                            <div class="input-group pull-right">
                                <input type="daterangepicker" placeholder="{{ __('Ngày đăng ký') }}" class="form-control" readonly>
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
                            <input type="text" name="phone_number" class="form-control" placeholder="{{ __('Số điện thoại') }}">
                        </div>
                        <div class="col-lg-3 form-group">
                            <input type="text" class="form-control" data-original-title="{{ __('E-mail khách hàng') }}" data-toggle="tooltip" placeholder="{{ __('E-mail khách hàng') }}" name="email" id="email">
                        </div>

                        <div class="form-group col-lg-3"  data-original-title="{{ __('Trạng thái khách hàng') }}" data-toggle="tooltip">
                            <select name="status " class="form-control k_selectpicker" aria-placeholder="{{ __('Trạng thái') }}">
                                <option value="">--{{ __('Trạng thái khách hàng') }}--</option>
                                @foreach($userStatus as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Tìm kiếm') }}</button>
                        <button type="reset" class="btn btn-secondary">{{ __('Làm mới') }}</button>
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
                    {{ $title }}
                </h3>
            </div>
        </div>
        <div class="k-portlet__body">
            <!--begin: Datatable -->
            <table id="table_user-list-index" data-searching="true" data-request-url="{{ route('bo.api.users.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="username">{{ __('Tên tài khoản') }}</th>
                        <th data-property="name">{{ __('Tên') }}</th>
                        <th data-property="phone_number">{{ __('SĐT') }}</th>
                        <th data-property="email">{{ __('E-mail') }}</th>
                        <th data-name="status" data-badge data-property="serialized_status_name">{{ __('Trạng thái') }}</th>
                        <th data-property="last_logged_in_at">{{ __('Đăng nhập lần cuối') }}</th>
                        <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                        <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
                        <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
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
