@extends('backoffice.layouts.master')

@php
	$title = 'System Setting';

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => 'Manage Currency',
		],
		[
			'label' => 'Create New Currency',
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
						<h3 class="k-portlet__head-title">{{ __('Create New Currency') }}</h3>
					</div>
				</div>
				<form class="k-form" method="post" action="{{ route('bo.web.system-currencies.store') }}" id="systemCurrencyStoreForm">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="form-group">
							<label>{{ __('Currency') }} *</label>
							<select name="currency_id" id="currency_id" data-size="5" class="form-control k_selectpicker" data-live-search="true" required>
								<option default value="">--{{ __('Select Currency') }}--</option>
								@foreach ($currencies as $type => $options)
								<optgroup label="{{ $type }}">
									@foreach ($options as $option)
                                    <option
                                        {{ old('currency_id') == $option->id ? 'selected' : ''}}
                                        data-currency-name="{{ $option->name }}"
                                        data-currency-type="{{ $option->type }}"
                                        data-currency-code="{{ $option->code }}"
                                        data-currency-symbol="{{ $option->symbol }}"
                                        data-currency-decimals="{{ $option->decimals }}"
                                        title="{{ $option->code }} - {{ $option->name }}"
                                        data-tokens="{{ $type }}|{{ $option->name }}|{{ $option->code }}"
                                        data-subtext="{{ $option->name }}"
                                        value="{{ $option->id }}">{{ $option->code }}</option>
									@endforeach
								</optgroup>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>{{ __('Name') }} *</label>
							<input type="text" class="form-control" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name') }}" required>
						</div>
						<div class="form-group blockchain-network d-none">
							<label>{{ __('Blockchain Network') }} *</label>
							<select name="blockchain_networks[]" data-live-search="true" class="form-control k_selectpicker blockchain_network_selector" multiple data-selected-text-format="count > 3">
								@foreach($blockchainNetworks as $blockchainNetwork)
                                <option
                                    data-network-code="{{ $blockchainNetwork->network_code }}"
                                    value="{{ $blockchainNetwork->getKey() }}"
                                    {{ in_array($blockchainNetwork->getKey(), old("blockchain_networks", [])) ? 'selected' : '' }}>
                                    {{ $blockchainNetwork->network_code }}
                                </option>
								@endforeach
							</select>
						</div>
						<div class="form-group blockchainNetworksHolder mb-0">
							<div class="blockchainNetworksContent"></div>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label>{{ __('Order') }}</label>
								<input type="number" class="form-control" name="order" value="{{ old('order') }}">
							</div>
							<div class="col-md-6">
								<label>{{ __('Decimals') }}</label>
								<input type="number" class="form-control" name="decimals" max="18" min="0" value="{{ old('decimals') }}">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label>{{ __('Code') }}</label>
								<input type="text" class="form-control" name="code" disabled value="{{ old('code') }}">
							</div>
							<div class="col-md-6">
								<label>{{ __('Symbol') }}</label>
								<input type="text" class="form-control" name="symbol" disabled value="{{ old('symbol') }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-2 col-form-label">{{ __('Status') }}</label>
							<div class="col-3">
								<span class="k-switch">
									<label>
										<input type="checkbox" value="1" {{ boolean(old('status')) ? 'checked' : ''}} name="status" />
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

@section('js_script')
<script>
	$(document).ready(function() {
		$('#systemCurrencyStoreForm select[name="currency_id"]').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
			const selectedOption = $(this).find(':selected');

			$('#systemCurrencyStoreForm').find('input[name="name"]').val(selectedOption.data('currency-name'));
			$('#systemCurrencyStoreForm').find('input[name="code"]').val(selectedOption.data('currency-code'));
			$('#systemCurrencyStoreForm').find('input[name="symbol"]').val(selectedOption.data('currency-symbol'));
			$('#systemCurrencyStoreForm').find('input[name="decimals"]').val(selectedOption.data('currency-decimals'));

			if (selectedOption.data('currency-type') == "{{ $currencyTypeEnum::CRYPTO }}") {
				$('.blockchain-network').removeClass('d-none');
				$('.blockchain_network_selector').attr('required', 'required');
			} else {
				$('.blockchain-network').addClass('d-none');
				$('.blockchain_network_selector').removeAttr('required');
			}
		})

		$('#systemCurrencyStoreForm select[name="currency_id"]').trigger('changed.bs.select');
	})

	$('#systemCurrencyStoreForm select[name="currency_id"]').on('change', function () {
		$('.blockchainNetworksHolder').find('.blockchainNetworksContent').html('');
		$('.blockchain_network_selector').val('');
		$('.blockchain_network_selector').selectpicker('refresh');
	});

	const blockchainNetworkBadge = {
		id: null,
		parseFromObject: function(blockchainNetworkObj) {
			this.id = blockchainNetworkObj?.id;
			this.networkCode = blockchainNetworkObj?.networkCode;

			return this;
		},
		render: function() {
			return $(`<button type="button" title="{{ __('Remove') }}" class="blockchainNetworkBadgeSelected btn btn-sm btn-primary btn-right-icon mr-3 mb-3">`)
				.data('id', this.id)
				.append($(`<span class="payment-content">`).text(this.networkCode))
				.append($('<i class="la la-close">'));
		}
	}

	$('select.blockchain_network_selector').on('loaded.bs.select', function() {
		$(this).trigger('changed.bs.select');
	})

	$('select.blockchain_network_selector').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		let $this = $(this);
		let blockchainNetworksHolder = $('.blockchainNetworksHolder');
		let blockchainNetworkObjects = [];

		blockchainNetworksHolder.find('.blockchainNetworksContent').html('');

		$.each($this.val(), function(i, blockchainNetworkId) {
			let blockchainNetworkObj = {
				id: $this.find(`option[value="${blockchainNetworkId}"]`).first().val(),
				networkCode: $this.find(`option[value="${blockchainNetworkId}"]`).first().data('network-code'),
			}
			blockchainNetworkObjects.push(blockchainNetworkObj);
		});

		if ($.isEmptyObject(blockchainNetworkObjects)) {
			blockchainNetworksHolder.find('.blockchainNetworksContent').html('');
			blockchainNetworksHolder.addClass('d-none');
		} else {
			blockchainNetworksHolder.removeClass('d-none');
			blockchainNetworkObjects.map(function(blockchainNetworkObj) {
				generatePaymentBadge(blockchainNetworkObj, blockchainNetworksHolder);
			});
		}
	});

	$(document).on('click', '.blockchainNetworkBadgeSelected', function() {
		const blockchainNetworkObj = {
			id: $(this).data('id'),
			networkCode: $(this).data('networkCode'),
		}

		const selector = $('select.blockchain_network_selector');

		selector.find(`option[value="${blockchainNetworkObj.id}"]`).prop('selected', false);
		selector.trigger('changed.bs.select').selectpicker('render');
	})

	function generatePaymentBadge(blockchainNetworksHolder, holderSelector) {
		if ($.isEmptyObject(blockchainNetworksHolder)) {
			return;
		}
		$(holderSelector).find('.blockchainNetworksContent')
            .append(blockchainNetworkBadge.parseFromObject(blockchainNetworksHolder).render());
	}
</script>
@endsection
