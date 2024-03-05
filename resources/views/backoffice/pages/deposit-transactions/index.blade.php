@extends('backoffice.layouts.master')

@php
	$title = __('Giao dịch gửi tiền');

	$breadcrumbs = [
		[
			'label' => $title,
        ],
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@section('style')
<style>
    [data-status].active {
        border-bottom: 2px solid #fff;
    }
</style>
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">

    @include('backoffice.pages.deposit-transactions.partials.statistic')
    @include('backoffice.pages.deposit-transactions.partials.search-form')

    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Danh sách giao dịch tiền gửi') }}
                </h3>
            </div>
        </div>
        <div class="k-portlet__body">
            <table id="table_deposit_transactions_index" data-searching="true" data-request-url="{{ route('bo.api.deposit-transactions.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="user.name" data-link="user.edit_link" data-link-target="_blank">{{ __('Tên khách hàng') }}</th>
                        <th data-property="amount">{{ __('Số tiền') }}</th>
                        <th data-property="payment_option.name" data-link="payment_option.edit_link" data-link-target="_blank">{{ __('Phương thức') }}</th>
                        <th data-orderable="false" data-property="order.order_code" data-render-callback="renderCallbackOrder">{{ __('Mã đơn hàng') }}</th>
                        <th data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                        <th data-property="reference_id" >{{ __('Tham chiếu') }}</th>
                        <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                        <th data-property="updated_at">{{ __('Xử lý lúc') }}</th>
                        <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" data-model="deposit-transaction" role="dialog" aria-hidden="true">

</div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script>
    const ORDER_STATUS_ENUM = {
        DECLINED: 0,
        WAITING_FOR_PAYMENT: 1,
        PAYMENT_ERROR: 2,
        PROCESSING: 3,
        DELIVERY: 4,
        COMPLETED: 5,
        CANCELED: 6,
        REFUNDED: 7,
    };

    const DEPOSIT_STATUS_ENUM = {
        DECLINED: 0,
        PENDING: 1,
        APPROVED: 2,
        CANCELED: 3,
        FAILED: 4,
    };

    function renderCallbackOrder(data, type, full) {
        const dom = $('<div class="text-center">');

        if (full?.order?.edit_link) {
            dom.append(`<a href="${full?.order?.edit_link}" target="_blank" class="mb-2 d-block">${data || 'N/A'}</a>`)
        } else {
            dom.append(`<span>N/A</span>`);
        }

        if (full?.order?.order_status_name) {
            let statusClass = '';

            switch (full?.order?.order_status) {
                case ORDER_STATUS_ENUM.DECLINED:
                case ORDER_STATUS_ENUM.CANCELED:
                case ORDER_STATUS_ENUM.REFUNDED:
                    statusClass = 'text-danger';
                    break;
                case ORDER_STATUS_ENUM.PAYMENT_ERROR:
                    statusClass = 'text-warning';
                    break;
                case ORDER_STATUS_ENUM.PROCESSING:
                case ORDER_STATUS_ENUM.DELIVERY:
                    statusClass = 'text-primary';
                    break;
                case ORDER_STATUS_ENUM.COMPLETED:
                    statusClass = 'text-success';
                    break;
                default:
                    break;
            }

            dom.append(`<small class="d-block ${statusClass}">(${full?.order?.order_status_name})</small>`);
        }

        return dom.prop('outerHTML');
    }

    const DEPOSIT_TRANSACTION = {
        init: () => {
            DEPOSIT_TRANSACTION.statistic(DEPOSIT_STATUS_ENUM.PENDING);
            DEPOSIT_TRANSACTION.statistic(DEPOSIT_STATUS_ENUM.CANCELED);
            DEPOSIT_TRANSACTION.statistic(DEPOSIT_STATUS_ENUM.APPROVED);
            DEPOSIT_TRANSACTION.statistic(DEPOSIT_STATUS_ENUM.DECLINED);

            DEPOSIT_TRANSACTION.loadTotalDeposit();
            DEPOSIT_TRANSACTION.onClickStatistic();
            DEPOSIT_TRANSACTION.onShowDetail();
        },
        onClickStatistic: () => {

        },
        onShowDetail: () => {
            $(document).on('click', '[data-action=show]', function(e) {
                e.preventDefault();

                const $modal = $('[data-model="deposit-transaction"]');

                const route = $(this).attr('href');

                $.ajax({
                    url: route,
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    beforeSend: () => {
                        $modal.empty();
                    },
                    success: function(response) {
                        $modal.html(response);
                        $modal.modal('show');

                        $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});
                    }
                });
            });
        },
        statistic: (status) => {
            const element = $(`[data-status="${status}"]`);
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
        loadTotalDeposit: (data = null) => {
            const $table = $('#table_deposit_transactions_index');

            $.ajax({
                url: "{{ route('bo.api.deposit-transactions.statistic.amount') }}",
                method: 'GET',
                success: (response) => {
                    $table.find('tfoot').remove();

                    const tfoot = $('<tfoot>');
                    const tfootTotalCol = $('<td>').attr('colspan', 2).attr('rowspan', Object.keys(response).length).text("{{ __('Tổng cộng') }}");

                    $.each(response, function(currency, total) {
                        const tfootRow = $('<tr>').append(
                            $('<td>').attr('colspan', 10).addClass('statistic-amount').html(`<b>${fscommon.formatPrice(total, currency)}</b>`)
                        )

                        tfoot.append(tfootRow);
                    });

                    tfoot.find('tr:first').prepend(tfootTotalCol);
                    $table.append(tfoot);
                },
            })
        },
    };

    function reloadTable(orderStatus) {
        const $form  = $('#search_table_deposit_transactions_index');
        const $table = $('#table_deposit_transactions_index');

        $(`[data-status]`).removeClass('active');
        $(`[data-status="${orderStatus}"]`).addClass('active');

        $form.trigger('reset', [{}, false]);

        removeRequestParams('table_deposit_transactions_index', 'reset_form');

        $form.find('input[name="status"]').val(orderStatus);

        $table.DataTable().ajax.reload(function(data) {
            $form.find(':submit').prop('disabled', false);
            DEPOSIT_TRANSACTION.loadTotalDeposit();
        });
    }

    function initOrderStatisticActive() {
        $(document).ready(function() {
            const data = $('#table_deposit_transactions_index').DataTable().ajax.params();

            $(`[data-status="${data?.status}"]`).addClass('active');
        });
    }

    function setFilterParams() {
        $(`[data-status]`).removeClass('active');
    }

    initOrderStatisticActive();

    DEPOSIT_TRANSACTION.init();
</script>
@endsection
