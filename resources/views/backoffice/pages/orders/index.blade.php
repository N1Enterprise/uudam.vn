@extends('backoffice.layouts.master')

@php
	$title = __('Orders');

	$breadcrumbs = [
		[
			'label' => $title,
		]
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@section('style')
<style>
    [data-order-status].active {
        border-bottom: 2px solid #fff;
    }
</style>
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
    <div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">

        @include('backoffice.pages.orders.partials.statistic')
        @include('backoffice.pages.orders.partials.search-form')

        <div class="k-portlet k-portlet--mobile">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">
                        {{ __('Order') }}
                    </h3>
                </div>
            </div>
            <div class="k-portlet__body">
                <table id="table_orders_index" data-searching="true" data-request-url="{{ route('bo.api.orders.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-property="order_code">{{ __('Order Code') }}</th>
                            <th data-orderable="false" data-property="user.name">{{ __('User Name') }}</th>
                            <th data-property="fullname">{{ __('Full Name') }}</th>
                            <th data-property="email">{{ __('E-mail') }}</th>
                            <th data-property="phone">{{ __('Phone Number') }}</th>
                            <th data-property="total_item">{{ __('Total Item') }}</th>
                            <th data-property="total_quantity">{{ __('Total Quantity') }}</th>
                            <th data-orderable="false" data-badge data-name="payment_status" data-property="payment_status_name">{{ __('Payment Status') }}</th>
                            <th data-orderable="false" data-badge data-name="order_status" data-property="order_status_name">{{ __('Order Status') }}</th>
                            <th data-orderable="false" data-property="created_by.name">{{ __('Ngày tạo') }}</th>
                            <th data-orderable="false" data-property="updated_by.name">{{ __('Ngày cập nhật') }}</th>
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
    const ORDER_STATUS_ENUM = {
        WAITING_FOR_PAYMENT: 1,
        PAYMENT_ERROR: 2,
        PROCESSING: 3,
        DELIVERY: 4,
        COMPLETED: 5,
        CANCELED: 6,
        REFUNDED: 7,
    };

    const ORDER_STATUS_STATISTIC = {
        init: () => {
            ORDER_STATUS_STATISTIC.statistic(ORDER_STATUS_ENUM.WAITING_FOR_PAYMENT);
            ORDER_STATUS_STATISTIC.statistic(ORDER_STATUS_ENUM.PAYMENT_ERROR);
            ORDER_STATUS_STATISTIC.statistic(ORDER_STATUS_ENUM.PROCESSING);
            ORDER_STATUS_STATISTIC.statistic(ORDER_STATUS_ENUM.DELIVERY);
            ORDER_STATUS_STATISTIC.statistic(ORDER_STATUS_ENUM.COMPLETED);
            ORDER_STATUS_STATISTIC.statistic(ORDER_STATUS_ENUM.CANCELED);
            ORDER_STATUS_STATISTIC.statistic(ORDER_STATUS_ENUM.REFUNDED);
        },
        statistic: (status) => {
            const element = $(`[data-order-status="${status}"]`);
            const api = $(element).attr('data-api');

            $(element).html('<i class="fa fa-sync fa-spin"></i>');

            $.ajax({
                url: api,
                method: 'GET',
                success: (response) => {
                    $(element).text(response.count || 0);
                }
            });
        },
    };

    function reloadTable(orderStatus) {
        const $form  = $('#search_table_orders_index');
        const $table = $('#table_orders_index');

        $(`[data-order-status]`).removeClass('active');
        $(`[data-order-status="${orderStatus}"]`).addClass('active');

        $form.trigger('reset', [{}, false]);

        removeRequestParams('table_orders_index', 'reset_form');

        $form.find('input[name="order_status"]').val(orderStatus);

        $table.DataTable().ajax.reload(function(data) {
            $form.find(':submit').prop('disabled', false);
        });
    }

    function initOrderStatisticActive() {
        $(document).ready(function() {
            const data = $('#table_orders_index').DataTable().ajax.params();

            $(`[data-order-status="${data?.order_status}"]`).addClass('active');
        });
    }

    function setFilterParams() {
        $(`[data-order-status]`).removeClass('active');
    }

    initOrderStatisticActive();

    ORDER_STATUS_STATISTIC.init();
</script>
@endsection
