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
			'label' => 'Withdraw Banks',
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
					{{__('Withdraw Banks')}}
				</h3>
			</div>
            @can('withdraw-banks.store')
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    <a href="{{ route('bo.web.withdraw-banks.create') }}" class="btn btn-default btn-bold btn-upper btn-font-sm">
                        <i class="flaticon2-add-1"></i>
                        {{__('Create New Withdraw Bank')}}
                    </a>

                </div>
            </div>
            @endcan
		</div>
		<div class="k-portlet__body">

			<!--begin: Datatable -->
			<table data-request-url="{{ route('bo.api.withdraw-banks.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object" id="k_table_1">
				<thead>
					<tr>
						<th data-property="id">{{ __('ID') }}</th>
						<th data-property="name">{{ __('Bank Name') }}</th>
						<th data-property="code">{{ __('Bank Code') }}</th>
						<th data-name="currency_code" data-property="currency.code">{{ __('Currency') }}</th>
						<th data-name="status" data-badge data-property="status_name">{{ __('Status') }}</th>
						<th data-name="type"  data-property="type_name">{{ __('Type') }}</th>
						<th data-property="created_at">{{ __('Created At') }}</th>
						<th data-property="updated_at">{{ __('Updated At') }}</th>
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
