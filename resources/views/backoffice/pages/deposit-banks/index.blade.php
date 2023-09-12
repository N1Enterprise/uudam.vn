@extends('backoffice.layouts.master')

@php
	$title = 'Payments';

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => 'Payment Settings',
		],
		[
			'label' => 'Deposit Bank',
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
					{{ __('Deposit Bank') }}
				</h3>
			</div>
            @can('deposit-banks.store')
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    <a href="{{ route('bo.web.deposit-banks.create') }}" class="btn btn-default btn-bold btn-upper btn-font-sm">
                        <i class="flaticon2-add-1"></i>
                        {{ __('Create New Bank Account') }}
                    </a>

                </div>
            </div>
            @endcan
		</div>
		<div class="k-portlet__body">
			<!--begin: Datatable -->
			<table data-request-url="{{ route('bo.api.deposit-banks.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object" id="k_table_1">
				<thead>
					<tr>
						<th data-property="id">{{ __('ID') }}</th>
						<th data-property="name">{{ __('Bank Name') }}</th>
						<th data-priority="2" data-property="payment_type" data-render-callback="renderPaymentTypeData">{{ __('Type') }}</th>
						<th data-property="code">{{ __('Bank Code') }}</th>
						<th data-property="account_name">{{ __('Account Name') }}</th>
						<th data-property="account_number">{{ __('Account Number') }}</th>
						<th data-name="currency_code" data-property="currency.code">{{ __('Currency') }}</th>
						<th data-name="status" data-badge data-property="status_name">{{ __('Status') }}</th>
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
			<!--end: Datatable -->
		</div>
	</div>
</div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script>
    window.paymentType = @json(enum('PaymentTypeEnum')::labels());

    function renderPaymentTypeData(data, type, transactionLog) {
        let paymentType = transactionLog?.payment_type;
        let paymentTypeName = [];
        if (paymentType && paymentType.length > 0) {
            for (let index = 0; index < paymentType.length; index++) {
                if (paymentType[index] in window.paymentType) {
                    paymentTypeName.push(window.paymentType[paymentType[index]]);
                }
            }
            return paymentTypeName.join('<br> ');
        }

        return null;
    }
</script>
@endsection
