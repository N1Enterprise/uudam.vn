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
			'label' => 'Edit Withdraw Bank',
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
						<h3 class="k-portlet__head-title">{{ __('Edit Withdraw Bank') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab" aria-selected="true">
									{{ __('Main') }}
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#cmsTab" role="tab">
									{{ __('Advance') }}
								</a>
							</li>
						</ul>
					</div>
				</div>
				<form class="k-form" method="post" action="{{ route('bo.web.withdraw-banks.update', $withdrawBank->getKey()) }}" id="update_withdraw_bank">
					@csrf
					@method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Bank Name') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter bank name') }}" value="{{ old('name', $withdrawBank->name) }}" required>
								</div>
								<div class="form-group">
									<label for="bank_code">{{ __('Bank Code') }} *</label>
									<input type="text" class="form-control" name="code" placeholder="{{ __('Enter bank code') }}" value="{{ old('code', $withdrawBank->code) }}" required>
								</div>
								<div class="form-group">
									<label for="exampleSelect1">{{ __('Currency') }} *</label>
									<select name="currency_code" id="currency_code" data-size="5" class="form-control k_selectpicker" data-live-search="true" required>
										<option default value="">--{{ __('Select Currency') }}--</option>
										@foreach ($currencies as $type => $options)
										<optgroup label="{{ $type }}">
											@foreach ($options as $option)
												@php
													$blockchainNetworks = $option->blockchainNetworks->where('status', enum('ActivationStatusEnum')::ACTIVE)
														->map->only(['id', 'name', 'long_name', 'network_code']);
												@endphp
												<option
													{{ old('currency_code', $withdrawBank->currency_code) == $option->getKey() ? 'selected' : ''}}
													data-type="{{ $option->type }}"
													data-blockchain-networks="{{ $blockchainNetworks }}"
													title="{{ $option->code }} - {{ $option->name }}"
													value="{{ $option->getKey() }}"
                                                >{{$option->code}}</option>
											@endforeach
										</optgroup>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label for="exampleSelect1">{{ __('Bank type') }} *</label>
									<select class="form-control" id="bank_type" name="type" required>
										@foreach ($userBankTypes as $type)
                                        <option {{ old('type', $withdrawBank->type) == data_get($type, 'id') ? 'selected' : '' }} value="{{ data_get($type, 'id') }}">{{ data_get($type, 'name') }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group d-none blockchain_network">
									<label class="blockchian-network-label">{{ __('Blockchain Networks') }} *</label>
									<select class="form-control k_selectpicker blockchain_network_selector" name="blockchain_networks[]" data-live-search="true" multiple data-selected-text-format="count > 3">
									</select>
								</div>
								<div class="form-group blockchainNetworksHolder mb-0" data-payment-option-type="type">
									<div class="blockchainNetworksContent"></div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Status') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												@if(old('status'))
												<input type="checkbox" {{ old('status') == 'on' ? 'checked' : ''}} name="status"/>
												@else
												<input type="checkbox" {{ $withdrawBank->isActive() ? 'checked' : ''}} name="status"/>
												@endif
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="cmsTab" role="tabpanel">
                                <div id="restrictionTab">
                                    <div class="form-group">
                                        <label>{{ __('Select Allowed Countries') }}</label>
                                        <input type="hidden" name="withdraw_bank_allowed_countries[]" value="">
                                        <select data-actions-box="true" name="withdraw_bank_allowed_countries[]" title="--{{ __('Select Country') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker withdraw_bank_allowed_country_selector" multiple data-selected-text-format="count > 5">
                                            @foreach($countries as $country)
                                            <option
                                                {{ in_array($country->iso2, old("withdraw_bank_allowed_countries", $withdrawBank->allowedCountries->pluck('iso2')->all())) ? 'selected' : '' }}
                                                data-tokens="{{ $country->iso2 }} | {{ $country->name }}"
                                                data-subtext="{{ $country->iso2 }}"
                                                data-country-iso2="{{ $country->iso2 }}"
                                                data-country-name="{{ $country->name }}"
                                                value="{{ $country->iso2 }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group withdrawBankAllowedCountryOptionHolder mb-0">
                                        <div class="withdrawBankAllowedCountryHolderContent"></div>
                                    </div>
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

				<input type="hidden" id="blockchainNetWorkSetting" value='@json($blockchainNetworks)'>
				<input type="hidden" id="oldBlockchainNetwork" value='@json(old("blockchain_networks", $withdrawBank->blockchain_networks))'>
				<input type="hidden" id="oldBankType" value='{{old("type", $withdrawBank->type)}}'>
				<input type="hidden" id="bankTypeEnum" value='@json($bankTypeEnum::labelsOf($bankTypeEnum::fiatTypes()))'>
				<input type="hidden" id="cryptoTypeEnum" value='@json($bankTypeEnum::labelsOf($bankTypeEnum::cryptoTypes()))'>
				<!--end::Form-->
			</div>
		</div>
	</div>
</div>
@endsection
@section('js_script')
<script>
    let reload = true;

    $(document).ready(function() {
        $('select#currency_code').trigger('change')
    });

    let blockchainNetworkBadge = {
        id: null,
        parseFromObject: function(blockchainNetworkObj) {
            this.id = blockchainNetworkObj?.id

            return this;
        },
        render: function() {
            return $(`<button type="button" title="{{ __('Remove') }}" class="blockchainNetworkBadgeSelected btn btn-sm btn-primary btn-right-icon mr-3 mb-3">`)
                .data('id', this.id)
                .append(
                    $(`<span class="payment-content">`).text(this.id)
                )
                .append(
                    $('<i class="la la-close">')
                )
        }
    }

    $('select.blockchain_network_selector').on('loaded.bs.select', function() {
        $(this).trigger('changed.bs.select');
    })

    $('select.blockchain_network_selector').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        let $this = $(this)
        let blockchainNetworksHolder = $('.blockchainNetworksHolder');
        let blockchainNetworkObjects = [];

        blockchainNetworksHolder.find('.blockchainNetworksContent').html('')

        $.each($this.val(), function(i, blockchainNetworkId) {
            let blockchainNetworkObj = {
                id: $this.find(`option[value="${blockchainNetworkId}"]`).first().val(),
            }

            blockchainNetworkObjects.push(blockchainNetworkObj)
        })

        if ($.isEmptyObject(blockchainNetworkObjects)) {
            blockchainNetworksHolder.find('.blockchainNetworksContent').html('')
            blockchainNetworksHolder.addClass('d-none')
        } else {
            blockchainNetworksHolder.removeClass('d-none')
            blockchainNetworkObjects.map(function(blockchainNetworkObj) {
                generatePaymentBadge(blockchainNetworkObj, blockchainNetworksHolder)
            })
        }
    });

    $(document).on('click', '.blockchainNetworkBadgeSelected', function() {
        let blockchainNetworkObj = {
            id: $(this).data('id'),
        }

        let selector = $('select.blockchain_network_selector');

        selector.find(`option[value="${blockchainNetworkObj.id}"]`).prop('selected', false);
        selector.trigger('changed.bs.select').selectpicker('render');
    })

    function generatePaymentBadge(blockchainNetworksHolder, holderSelector) {
        if ($.isEmptyObject(blockchainNetworksHolder)) {
            return
        }

        $(holderSelector).find('.blockchainNetworksContent').append(blockchainNetworkBadge.parseFromObject(blockchainNetworksHolder).render());
    }

    $('#currency_code').on('change', function() {
        let currency = $(this).find(':selected');

        generateBankType();

        if (currency.data('type') == '{{ $currencyTypeEnum::CRYPTO }}') {
            $('.blockchain_network').removeClass('d-none');
            $('select[name=blockchain_networks\\[\\]]').attr('required', 'required');
            generateBlockchainNetwork(currency.val());
        } else {
            $('.blockchain_network').addClass('d-none');
            $('.blockchainNetworksContent').html('');
            $('select[name=blockchain_networks\\[\\]]').empty()
            $('select[name=blockchain_networks\\[\\]]').removeAttr('required');
        }
    });

    function generateBlockchainNetwork(currencyCode) {
        $('.blockchainNetworksContent').html('');

        let blockchainNetworkElement = $('select[name=blockchain_networks\\[\\]]');
        let blockchainNetWorks = $('select[name=currency_code]').find(':selected').data('blockchain-networks') ?? [];

        let selected = '';

        if (reload) {
            selected = $('input#oldBlockchainNetwork').val();
        }

        blockchainNetworkElement.empty();

        if (blockchainNetWorks) {
            for(let i in blockchainNetWorks) {
                let option = $(`<option value="${data_get(blockchainNetWorks[i], 'network_code')}" ${selected !== '' && selected.includes(data_get(blockchainNetWorks[i], 'network_code')) ? 'selected' : ''} >`)
                            .text(data_get(blockchainNetWorks[i], 'name'));
                blockchainNetworkElement.append(option);
            }
        }

        reload = false;

        blockchainNetworkElement.selectpicker('refresh');
    }

    function generateBankType() {
        let bankType = JSON.parse($('input#bankTypeEnum').val());
        let crytoType = JSON.parse($('input#cryptoTypeEnum').val());
        let currency = $('select[name=currency_code]').find(':selected');
        let typeElement = $('#bank_type');
        let selected = $('input#oldBankType').val();

        if (currency.data('type') == '{{ $currencyTypeEnum::CRYPTO }}') {
            typeElement.empty();

            for(let i in crytoType) {
                let option = $(`<option value="${i}" ${selected == i ? 'selected' : ''} >`)
                            .text(crytoType[i]);
                typeElement.append(option);
            }
        } else if (currency.data('type') == '{{ $currencyTypeEnum::FIAT }}') {
            typeElement.empty();

            for(let i in bankType) {
                let option = $(`<option value="${i}" ${selected == i ? 'selected' : ''} >`)
                            .text(bankType[i]);
                typeElement.append(option);
            }
        } else {
            return;
        }

        typeElement.selectpicker('refresh');
    }
</script>

<script>
    let withdrawBankAllowedCountryBadge = {
        iso2: null,
        name: null,
        parseFromObject: function(obj) {
            this.iso2 = obj?.iso2;
            this.name = obj?.name;

            return this;
        },
        render: function() {
            return $(`<button type="button" title="{{ __('Remove') }}" class="withdrawBankAllowedCountryBadgeSelected btn btn-sm btn-outline-brand btn-primary btn-right-icon mr-3 mb-3">`)
                .data('iso2', this.iso2)
                .data('name', this.name)
                .append(
                    $(`<span class="bonus-content">`).text(`${this.name} - ${this.iso2}`)
                )
                .append(
                    $('<i class="la la-close">')
                )
        }
    }

    $(document).ready(function () {
        $('form#update_withdraw_bank').find('input[name="name"]').on('change keyup', function() {
            let nameVal = $(this).val();

            let nameValSlugify = nameVal?.trim()?.toLowerCase()?.replace(/[^\w-]+/g, '-');

            $('form#update_withdraw_bank').find('input[name="slug"]').val(nameValSlugify);
        })

        $('select.withdraw_bank_allowed_country_selector').on('loaded.bs.select', function() {
            $(this).trigger('changed.bs.select');
        })

        $('select.withdraw_bank_allowed_country_selector').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            let $this = $(this)
            let optionHolder = $(`.withdrawBankAllowedCountryOptionHolder`);
            let restrictionCountries = [];

            optionHolder.find('.withdrawBankAllowedCountryHolderContent').html('');

            $.each($this.val(), function(i, iso2) {
                let obj = {
                    iso2: $this.find(`option[value="${iso2}"]`).first().val(),
                    name: $this.find(`option[value="${iso2}"]`).first().data('country-name'),
                }

                restrictionCountries.push(obj);
            })

            if ($.isEmptyObject(restrictionCountries)) {
                optionHolder.find('.withdrawBankAllowedCountryHolderContent').html('');
                optionHolder.addClass('d-none');
            } else {
                optionHolder.removeClass('d-none');

                restrictionCountries.map(function(obj) {
                    generateRestrictionCountryBadge(obj, optionHolder);
                })
            }
        });

        function generateRestrictionCountryBadge(obj, holderSelector) {
            if ($.isEmptyObject(obj)) {
                return;
            }

            $(holderSelector).find('.withdrawBankAllowedCountryHolderContent').append(withdrawBankAllowedCountryBadge.parseFromObject(obj).render());
        }
    })

    $(document).on('click', '.withdrawBankAllowedCountryBadgeSelected', function() {
        let obj = {
            iso2: $(this).data('iso2'),
            name: $(this).data('name'),
        }

        let selector = $(`select.withdraw_bank_allowed_country_selector`);

        selector.find(`option[value="${obj.iso2}"]`).prop('selected', false);
        selector.trigger('changed.bs.select').selectpicker('render');
    })
</script>
@endsection
