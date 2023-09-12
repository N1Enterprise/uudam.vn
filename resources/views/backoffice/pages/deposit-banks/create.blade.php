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
			'label' => 'Create New Deposit Bank',
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
		<div class="col-md-6">
			<!--begin::Portlet-->
			<div class="k-portlet">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Create New Deposit Bank') }}</h3>
					</div>
				</div>
				<form class="k-form" method="post" action="{{ route('bo.web.deposit-banks.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="form-group">
							<label>{{ __('Bank Name') }} *</label>
							<input type="text" class="form-control" name="name" placeholder="{{ __('Enter bank name') }}" value="{{ old('name') }}" required>
						</div>
						<div class="form-group">
							<label for="bank_code">{{ __('Bank Code') }} *</label>
							<input type="text" class="form-control" name="code" placeholder="{{ __('Enter bank code') }}" value="{{ old('code') }}" required>
						</div>
						<div class="form-group">
							<label for="account_name">{{ __('Account Name') }} *</label>
							<input type="text" class="form-control" name="account_name" placeholder="{{ __('Enter account name') }}" value="{{ old('account_name') }}" required>
						</div>
						<div class="form-group">
							<label for="account_number">{{ __('Account Number') }} *</label>
							<input type="text" class="form-control" name="account_number" placeholder="{{ __('Enter account number') }}" value="{{ old('account_number') }}" required>
						</div>
						<div class="form-group">
							<label for="banch">{{ __('Branch Name') }}</label>
							<input type="text" class="form-control" name="branch" placeholder="{{ __('Enter branch name') }}" value="{{ old('branch') }}">
						</div>
						<div class="form-group">
							<label for="exampleSelect1">{{ __('Currency') }}</label>
							<select class="form-control k_selectpicker" data-live-search="true" id="currency_code" name="currency_code" required>
								@foreach ($currencies as $currency)
                                <option {{ old('currency_code') == $currency->getKey() ? 'selected' : '' }} value="{{ $currency->getKey() }}">{{ $currency->getKey() }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>{{ __('Type') }} *</label>
							<div class="k-checkbox-inline">
								@foreach ($paymentTypes as $key => $paymentType)
                                <label class="k-checkbox">
                                    <input type="checkbox" {{ in_array($key, old('payment_type', [])) ? 'checked' : '' }} value="{{ $key }}" name="payment_type[]"> {{ $paymentType }}
                                    <span></span>
                                </label>
								@endforeach
							</div>
						</div>

						<div class="form-group row">
							<label class="col-2 col-form-label">{{ __('Status') }}</label>
							<div class="col-3">
								<span class="k-switch">
									<label>
										<input type="checkbox" {{ old('status') == 'on'  ? 'checked' : ''}} name="status" />
										<span></span>
									</label>
								</span>
							</div>
						</div>
					</div>
					<div class="k-portlet__foot">
						<div class="k-form__actions">
							<button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
							<button type="redirect" class="btn btn-secondary">{{ __('Cancel') }}</button>
						</div>
					</div>
				</form>
				<!--end::Form-->
			</div>
		</div>
	</div>
</div>
@endsection
