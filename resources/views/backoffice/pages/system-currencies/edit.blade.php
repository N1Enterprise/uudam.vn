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
			'label' => 'Edit Currency',
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
						<h3 class="k-portlet__head-title">{{ __('Edit Currency') }}</h3>
					</div>
				</div>
				<form class="k-form" method="post" action="{{ route('bo.web.system-currencies.update', $systemCurrency->getKey()) }}">
					@csrf
					@method('put')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="form-group">
							<label>{{ __('Name') }} *</label>
							<input type="text" class="form-control" name="name" value="{{ old('name', $systemCurrency->name) }}" required>
						</div>
						<div class="form-group blockchain-network {{ $systemCurrency->type !== $currencyTypeEnum::CRYPTO ? 'd-none' : ''}}">
							<label>{{ __('Blockchain Network') }} *</label>
							<select
								name="blockchain_networks[]"
								data-live-search="true"
								class="form-control k_selectpicker blockchain_network_selector"
								multiple data-selected-text-format="count > 3"
								{{ $systemCurrency->type === $currencyTypeEnum::CRYPTO ? 'required' : ''}}>
								@foreach($blockchainNetworks as $blockchainNetwork)
                                <option
                                    {{ in_array($blockchainNetwork->getKey(), old("blockchain_networks", $systemCurrency->blockchainNetworks->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}
                                    data-network-code="{{ $blockchainNetwork->network_code }}"
                                    value="{{ $blockchainNetwork->getKey() }}">
                                    {{ $blockchainNetwork->network_code }}
                                </option>
								@endforeach
							</select>
						</div>
						<div class="form-group blockchainNetworksHolder mb-0">
							<div class="blockchainNetworksContent">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label>{{ __('Order') }}</label>
								<input type="number" class="form-control" name="order" value="{{ old('order', $systemCurrency->order) }}">
							</div>
							<div class="col-md-6">
								<label>{{ __('Decimals') }}</label>
								<input type="number" max="18" min="0" class="form-control" name="decimals" value="{{ old('decimals', $systemCurrency->decimals) }}">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label>{{ __('Code') }}</label>
								<input type="text" class="form-control" name="code" disabled value="{{ old('code', $systemCurrency->code) }}">
							</div>
							<div class="col-md-6">
								<label>{{ __('Symbol') }}</label>
								<input type="text" class="form-control" name="symbol" disabled value="{{ old('symbol', $systemCurrency->code) }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-2 col-form-label">{{ __('Status') }}</label>
							<div class="col-3">
								<span class="k-switch">
									<label>
										<input type="hidden" name="status" value="0">
										<input type="checkbox" value="1" {{ old('status', $systemCurrency->status) == 1 ? 'checked' : ''}} name="status" />
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

				<input type="hidden" name="systemCurrencyType" disabled value="{{ $systemCurrency->type }}">
				<!--end::Form-->
			</div>
		</div>
	</div>
</div>
@endsection

@section('js_script')
<script>
	let blockchainNetworkBadge = {
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
				.append($('<i class="la la-close">'))
		}
	}

	$('select.blockchain_network_selector').on('loaded.bs.select', function() {
		$(this).trigger('changed.bs.select');
	})

	$('select.blockchain_network_selector').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		const $this = $(this)
		const blockchainNetworksHolder = $('.blockchainNetworksHolder');
		const blockchainNetworkObjects = [];

		blockchainNetworksHolder.find('.blockchainNetworksContent').html('')
		$.each($this.val(), function(i, blockchainNetworkId) {
			const blockchainNetworkObj = {
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
				generatePaymentBadge(blockchainNetworkObj, blockchainNetworksHolder)
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

		$(holderSelector).find('.blockchainNetworksContent').append(blockchainNetworkBadge.parseFromObject(blockchainNetworksHolder).render());
	}
</script>
@endsection
