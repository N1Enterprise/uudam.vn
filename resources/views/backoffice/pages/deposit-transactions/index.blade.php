@extends('backoffice.layouts.master')

@php
    $title = __('Payments');

    $breadcrumbs = [
        [
            'label' => $title,
        ],
        [
            'label' => __('Deposit List'),
        ]
    ];
@endphp

@section('header')
{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <div class="row">
        <!-- START::PENDING STATISTIC -->
        <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
            <div class="k-portlet k-portlet--height-fluid statistic text-light bg-primary p-4 pb-5 card-total-status search-all-month" style="padding-top: 2rem !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="pending-statistic">
                            111
                        </h1>
                    </div>
                </div>
				<div class="d-flex justify-content-between">
                    <div>
                        <h4>Pending</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- END::PENDING STATISTIC -->

        <!-- START::CANCELED STATISTIC -->
        <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
            <div class="k-portlet k-portlet--height-fluid statistic text-light bg-warning p-4 pb-5 card-total-status search-all-month" style="padding-top: 2rem !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="canceled-statistic">
                            111
                        </h1>
                    </div>
                </div>
				<div class="d-flex justify-content-between">
                    <div>
                        <h4>Canceled</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- END::CANCELED STATISTIC -->

        <!-- START::APPROVED STATISTIC -->
        <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
            <div class="k-portlet k-portlet--height-fluid statistic text-light bg-success p-4 pb-5 card-total-status search-all-month" style="padding-top: 2rem !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="approved-statistic">
                            111
                        </h1>
                    </div>
                </div>
				<div class="d-flex justify-content-between">
                    <div>
                        <h4>Approved</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- END::APPROVED STATISTIC -->

        <!-- START::DECLINED STATISTIC -->
        <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
            <div class="k-portlet k-portlet--height-fluid statistic text-light bg-danger p-4 pb-5 card-total-status search-all-month" style="padding-top: 2rem !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="declined-statistic">
                            111
                        </h1>
                    </div>
                </div>
				<div class="d-flex justify-content-between">
                    <div>
                        <h4>Declined</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- END::DECLINED STATISTIC -->
    </div>

    <div class="k-portlet">
        <!--begin::Form-->
        <form class="k-form k-form--label-right" data-datatable="index_deposit_transaction_table" id="search_deposit_transaction" method="GET">
            <div class="k-portlet__body">
				<div class="filter_body">
					<div class="row">
                        <div class="form-group col-lg-3">
							<input type="text" data-original-title="{{ __('Deposit ID') }}" data-toggle="tooltip" placeholder="{{ __('Deposit ID') }}" class="form-control" name="id" value="">
						</div>

                        <div class="form-group col-lg-3">
                            <div class="input-group pull-right" data-original-title="{{ __('Deposit ID') }}" data-toggle="tooltip">
                                <input type="daterangepicker" class="form-control" placeholder="{{ __('Select Deposit Time') }}" value="" name="created_at" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                                <input type="hidden" data-daterangepicker-catch="start" name="created_at_range[]">
                                <input type="hidden" data-daterangepicker-catch="end" name="created_at_range[]">
                            </div>
                        </div>

                        <div class="form-group col-lg-3">
							<x-search-username-input placeholder="{{ __('Username Or UserID') }}" name="username_or_user_id" id="username_or_user_id" />
						</div>

                        <div class="form-group col-lg-3">
							<select name="user_status" class="form-control k_selectpicker" data-original-title="{{ __('User Status') }}" data-toggle="tooltip" aria-placeholder="{{ __('User Status') }}">
								<option value="">--{{ __('User Status') }}--</option>
								@foreach($userStatuses as $key => $label)
								<option value="{{ $key }}">{{ $label }}</option>
								@endforeach
							</select>
						</div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-3">
                            <select class="form-control k_selectpicker" data-live-search="true" name="payment_option_id">
                                <option value="">--{{ __('Payment option') }}--</option>
                                @foreach($paymentOptions as $group => $items)
                                <optgroup label="{{ $group }}">
                                    @foreach($items as $option)
                                    <option data-subtext="{{ optional($option->paymentProvider)->name }}" value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                            <input name="payment_option_id_text" id="payment_option_id_text" type="hidden">
                        </div>

                        <div class="form-group col-lg-6">
							<select name="user_status" class="form-control k_selectpicker" data-original-title="{{ __('Deposit Status') }}" data-toggle="tooltip" aria-placeholder="{{ __('Deposit Status') }}">
                                <option value="">--{{ __('Deposit Status') }}--</option>
								@foreach($depositStatuses as $key => $label)
								<option value="{{ $key }}">{{ $label }}</option>
								@endforeach
							</select>
						</div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Search') }}</button>
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
					{{ __('Deposit List') }}
				</h3>
			</div>
			<div class="k-portlet__head-toolbar">
				<div class="k-portlet__head-toolbar-wrapper">
					@can('deposit-transactions.export')
					<x-exporter exporter="deposit-transactions" datatable="#index_deposit_transaction_table" />
					@endcan
				</div>
			</div>
		</div>

        <div class="k-portlet__body">
            <!--begin: Datatable -->
			<table data-request-url="{{ route('bo.api.deposit-transactions.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object" id="index_deposit_transaction_table">
				<thead>
					<tr>
						<th data-property="id">{{ __('ID') }}</th>
						<th data-property="user.username" data-render-callback="renderUserDetailLink">{{ __('User Name') }}</th>
						<th data-type="money" data-property="amount">{{ __('Amount') }}</th>
						<th data-property="payment_option.name">{{ __('Deposit Method') }}</th>
						<th data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
						<th data-property="reference_id">{{ __('Reference Id') }}</th>
						<th data-property="created_at">{{ __('Created At') }}</th>
						<th data-property="updated_at">{{ __('Processed At') }}</th>
						<th data-name="platform" data-property="platform_name">{{ __('Platform') }}</th>
						<th data-name="user.status" data-badge data-property="user.serialized_status_name">{{ __('User status') }}</th>
						<th class="datatable-action" data-property="actions">{{ __('Action') }}</th>
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

@push('modals')
<div class="modal fade" id="modal_detail_deposit_transaction" role="dialog" aria-hidden="true"></div>
@endpush

@section('js_script')
<script>
    function renderUserDetailLink(data, type, full, meta) {
		if (data_get(full, 'user.actions.show')) {
			const link = data_get(full, 'user.actions.show');

			return $('<a class="text-underline" target="__blank">').attr('href', link).text(data).prop('outerHTML');
		}

		return data;
	}

    onCopyToClipboard();

    function onCopyToClipboard() {
        $(document).on('click', '.copy-text-click', function () {
            copyToClipboard($(this).text());
            fstoast.success("{{ __('Copied clipboard.') }}");
        });
    }

    const TABLE_DEPOSIT_TRANSACTION = {
        init: () => {
            TABLE_DEPOSIT_TRANSACTION.renderSummaries();
            TABLE_DEPOSIT_TRANSACTION.onShow();
        },
        calculateTotalAmount: (data = null, callback = () => undefined) => {
            $.ajax({
                url: "{{ route('bo.api.deposit-transactions.total-amount') }}",
                method: 'GET',
                data: data ?? $('#search_deposit_transaction').serialize(),
                preventRedirectOnComplete: true,
                success: (response) => {
                    callback(response);
                },
                error: (error) => {
                    fstoast.error("{{ __('Fail to statistic total deposit amount.') }}");
                },
            });
        },
        renderSummaries: () => {
            TABLE_DEPOSIT_TRANSACTION.calculateTotalAmount(null, function(response) {
                $('#index_deposit_transaction_table').find('tfoot').remove();

                let tfoot = $('<tfoot>');

                let tfootTotalCol = $('<td>').attr('colspan', 2).attr('rowspan', Object.keys(response).length).text("{{ __('Total') }}");

                $.each(response, function(currency, total) {
                    let tfootRow = $('<tr>').append(
                        $('<td>').attr('colspan', 10).text(fscommon.formatMoney(total, currency))
                    );

                    tfoot.append(tfootRow);
                });

                tfoot.find('tr:first').prepend(tfootTotalCol);

                $('#index_deposit_transaction_table').append(tfoot);
            });
        },
        onShow: () => {
            $(document).on('click', 'a[data-action=show]', function(e) {
                e.preventDefault();

                $('#modal_detail_deposit_transaction').html('');

                const route = $(this).attr('href');

                $.ajax({
                    url: route,
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal_detail_deposit_transaction').html(response);
                        $('#modal_detail_deposit_transaction').modal('show')
                        $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'})

                        inputFormatter.formatInput();
                    }
                })
            });
        },
    };

    TABLE_DEPOSIT_TRANSACTION.init();
</script>
@endsection
