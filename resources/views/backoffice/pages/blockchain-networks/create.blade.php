@extends('backoffice.layouts.master')

@php
	$title = 'System Setting';

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => 'Manage Blockchain Network',
		],
		[
			'label' => 'Add Blockchain Network',
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
		<div class="col-md-8">

			<!--begin::Portlet-->
			<div class="k-portlet">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Add Blockchain Network') }}</h3>
					</div>
				</div>
				<form class="k-form" method="post" action="{{ route('bo.web.blockchain-networks.store') }}" id="blockchainNetworkStoreForm">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="form-group">
							<label>{{ __('Name') }} *</label>
							<input type="text" class="form-control" name="name"
								placeholder="{{ __('Enter name') }}" value="{{ old('name') }}" required>
						</div>
						<div class="form-group">
							<label>{{ __('Long Name') }} *</label>
							<input type="text" class="form-control" name="long_name"
								placeholder="{{ __('Enter name') }}" value="{{ old('long_name') }}" required>
						</div>
						<div class="form-group">
							<label>{{ __('Network Code') }} *</label>
							<input type="text" class="form-control" name="network_code"
								placeholder="{{ __('Enter network code') }}" value="{{ old('network_code') }}" required>
						</div>

						<div class="row">
                            <div class="col-md-6 form-group row">
                                <label class="col-md-5 col-form-label">{{ __('Status') }}</label>
                                <div class="col-3">
                                    <span class="k-switch">
                                        <label>
                                            <input type="checkbox" value="1" {{ boolean(old('status'))  ? 'checked' : ''}} name="status" />
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
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
