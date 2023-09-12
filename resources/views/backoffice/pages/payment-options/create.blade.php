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
			'label' => 'Create Payment Option',
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
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Create Payment Option') }}</h3>
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
				<form class="k-form" id="store_payment_option" method="post" action="{{ route('bo.web.payment-options.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Currency') }} *</label>
									<select name="currency_code" id="currency_code" data-size="5" class="form-control k_selectpicker" data-live-search="true" required onchange="onChangeCurrency()">
										<option default value="">--{{ __('Select Currency') }}--</option>
										@foreach ($currencies as $type => $options)
										<optgroup label="{{ $type }}">
											@foreach ($options as $option)
												@php
													$blockchainNetworks = $option->blockchainNetworks->where('status', enum('ActivationStatusEnum')::ACTIVE)
														->map->only(['id', 'name', 'long_name', 'network_code']);
												@endphp
												<option
													{{ old('currency_code') == $option->getKey() ? 'selected' : ''}}
													data-type="{{ $option->type }}"
													data-blockchain-networks="{{ $blockchainNetworks }}"
													title="{{ $option->code }} - {{ $option->name }}"
													value="{{$option->getKey()}}">{{$option->code}}
												</option>
											@endforeach
										</optgroup>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>{{ __('Payment Option Type') }} *</label>
									<select class="form-control k_selectpicker" id="type" name="type" required>
										@foreach ($paymentOptionTypes as $type => $label)
											@php
												$appendElementId = '';
												if($paymentOptionTypeEnum::isThirdParty($type)) {
													$appendElementId = 'payment_provider_id';
												} else if($paymentOptionTypeEnum::isLocalBank($type)) {
													$appendElementId = 'deposit_bank_id';
												}
											@endphp

											<option
                                                value="{{ $type }}"
                                                data-append="{{ $appendElementId }}"
                                                {{ old('type') == $type ? 'selected' : '' }}
                                            >{{ $label }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group depent_on_type">
									<label>{{ __('Payment Provider') }} *</label>
									<select class="form-control k_selectpicker" id="payment_provider_id" name="payment_provider_id">
									</select>
								</div>

								<div class="form-group d-none">
									<label class="blockchian-network-label">{{ __('Blockchain Networks') }} *</label>
									<select class="form-control k_selectpicker blockchain_network_selector" name="blockchain_networks[]" data-live-search="true" multiple data-selected-text-format="count > 3"></select>
								</div>
								<div class="form-group blockchainNetworksHolder mb-0" data-payment-option-type="type">
									<div class="blockchainNetworksContent"></div>
								</div>

								<div class="form-group online_banking_code_wrapper d-none">
									<label>{{ __('Online Bank') }} *</label>
									<select class="form-control k_selectpicker" id="online_banking_code" name="online_banking_code"></select>
								</div>

								<div class="form-group depent_on_type">
									<label>{{ __('Local Deposit Bank') }} *</label>
									<select class="form-control k_selectpicker" id="deposit_bank_id" name="deposit_bank_id"></select>
								</div>

								<div class="form-group">
									<label>{{ __('Payment Option Name') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter payment option name') }}" value="{{ old('name') }}" >
								</div>
								<div class="form-group">
									<label>{{ __('Min Amount') }}</label>
									<input type="text" class="form-control" name="min_amount" placeholder="{{ __('Enter min amount') }}" value="{{ old('min_amount') }}">
								</div>
								<div class="form-group">
									<label>{{ __('Max Amount') }}</label>
									<input type="text" class="form-control" name="max_amount" placeholder="{{ __('Enter max amount') }}" value="{{ old('max_amount') }}">
								</div>

								<div class="row">
									<div class="col-8 col-sm-4">
										<label class="col-form-label">{{ __('Status') }}</label>
									</div>
									<div class="col-4 col-sm-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status') == 'on'  ? 'checked' : ''}} name="status" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="row">
									<div class="col-8 col-sm-4">
										<label class="col-form-label">{{ __('Display on Front End') }}</label>
									</div>
									<div class="col-4 col-sm-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('display_on_frontend') || is_null(old('display_on_frontend')) == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend"/>
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
                                        <input type="hidden" name="payment_option_allowed_countries[]" value="">
                                        <select data-actions-box="true" name="payment_option_allowed_countries[]" title="--{{ __('Select Country') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker payment_option_allow_country_selector" multiple data-selected-text-format="count > 5">
                                            @foreach($countries as $country)
                                                <option
                                                    {{ in_array($country->iso2, old("payment_option_allowed_countries", [])) ? 'selected' : '' }}
                                                    data-tokens="{{ $country->iso2 }} | {{ $country->name }}"
                                                    data-subtext="{{ $country->iso2 }}"
                                                    data-country-iso2="{{ $country->iso2 }}"
                                                    data-country-name="{{ $country->name }}"
                                                    value="{{ $country->iso2 }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group paymentOptionAllowedCountryOptionHolder mb-0">
                                        <div class="paymentOptionAllowedCountryHolderContent"></div>
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

				<input type="hidden" id="banks" value='@json($banks)'>
				<input type="hidden" id="paymentProviders" value='@json($paymentProviders)'>
				<input type="hidden" id="paymentOptionTypes" value='@json($paymentOptionTypes)'>
				<input type="hidden" id="paymentOptionCryptoTypes" value='@json($paymentOptionCryptoTypes)'>
				<input type="hidden" id="oldPaymentProvider" value="{{ old('payment_provider_id') }}">
				<input type="hidden" id="oldPaymentOptionType" value="{{ old('type') }}">
				<input type="hidden" id="oldOnlineBankingCode" value="{{ old('online_banking_code') }}">
				<input type="hidden" id="oldDepositBank" value="{{ old('deposit_bank_id') }}">
				<input type="hidden" id="oldBlockchainNetwork" value='@json(old("blockchain_networks"))'>
				<input type="hidden" id="localBankTypes" value='@json($paymentOptionTypeEnum::localBankTypes())'>
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
        $('select#type').trigger('change')
    })

    let banks = JSON.parse($('input#banks').val());
    let paymentProviders = JSON.parse($('input#paymentProviders').val());
    let paymentOptionTypes = JSON.parse($('input#paymentOptionTypes').val());
    let paymentOptionCryptoTypes = JSON.parse($('input#paymentOptionCryptoTypes').val());
    let localBankTypes = JSON.parse($('input#localBankTypes').val())

    $('select#currency_code').on('change', function() {
        reloadDependenceElement($(this).val())
    })

    $('select#type').on('change', function() {
        $('select[name=online_banking_code]').empty();
        $('.depent_on_type').addClass('d-none')
        let selectedOption = $(this).find(':selected');
        appendElementId = selectedOption.attr('data-append');

        if(appendElementId) {
            $(`#${appendElementId}`).closest('.depent_on_type').removeClass('d-none')
        }
        if(appendElementId == 'payment_provider_id') {
            $('select#payment_provider_id').trigger('change');
        } else {
            $('.online_banking_code_wrapper').addClass('d-none');
        }
    })
    $('select#payment_provider_id').on('change', function() {
        let selectedOption = $(this).find(':selected');
        let params = selectedOption.data('params');

        if (!params) {
            return;
        }

        if(params.is_voucher) {
            return;
        }

        let currencyCodeSelected = $('select[name=currency_code]').find(':selected');
        if (currencyCodeSelected.attr('data-type') == '{{ $currencyTypeEnum::CRYPTO }}') {
            $('.online_banking_code_wrapper').addClass('d-none');
            return;
        }

        $('.online_banking_code_wrapper').removeClass('d-none');
        // Get Payment Option Types
        let paymentChannels = params.payment_channel ?? [];

        $('select[name=online_banking_code]').empty();
        let paymentChannelOption = [];

        for (bankCode in paymentChannels) {
            let bankGroupLabel = bankCode
                .toLowerCase()
                .replaceAll('_', ' ')
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');

            let bankGroupElement = $('<optgroup>').attr('label', bankGroupLabel).data('type', bankCode).addClass('text-capitalize');
            let bankOptions = [];
            let onlineBankSelected = $('#oldOnlineBankingCode').val();
            for (let option in paymentChannels[bankCode]) {
                let bankOptionElement = $('<option>').attr('selected', onlineBankSelected == option).attr('value', option).text(paymentChannels[bankCode][option]);
                bankOptions.push(bankOptionElement);
            }
            bankGroupElement.append(bankOptions);
            paymentChannelOption.push(bankGroupElement);
        }
        $('select[name=online_banking_code]').append(paymentChannelOption);
        setTimeout(function(){
            $('select[name=online_banking_code]').selectpicker('refresh');
        })
    })

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

        if($.isEmptyObject(blockchainNetworkObjects)) {
            blockchainNetworksHolder.find('.blockchainNetworksContent').html('')
            blockchainNetworksHolder.addClass('d-none')
        }else {
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
        if($.isEmptyObject(blockchainNetworksHolder)) {
            return
        }

        $(holderSelector).find('.blockchainNetworksContent').append(blockchainNetworkBadge.parseFromObject(blockchainNetworksHolder).render());
    }

    function onChangeCurrency() {
        let currencyCode = $('select[name=currency_code]').val();
        let blockchainNetworkElement = $('select[name=blockchain_networks\\[\\]]');
        let blockchainNetWorks = $('select[name=currency_code]').find(':selected').data('blockchain-networks') ?? [];

        let selected = '';

        if (reload) {
            selected = $('input#oldBlockchainNetwork').val();
        }

        blockchainNetworkElement.empty();
        $('.blockchainNetworksContent').html('');

        if (currencyCode == '') {
            blockchainNetworkElement.selectpicker('refresh');
            return;
        }

        $('select#type').html('');

        let currencyCodeSelected = $('select[name=currency_code]').find(':selected');

        if (currencyCodeSelected.attr('data-type') == '{{ $currencyTypeEnum::CRYPTO }}') {
            $('.blockchain_network_selector').attr('required', true);
            $('.blockchain_network_selector').parent().removeClass('d-none');
            $('.online_banking_code_wrapper').addClass('d-none');
            let optionSelected = $('input#oldPaymentOptionType').val();
            for(let i in paymentOptionCryptoTypes) {
                let option = $(`<option value="${i}" data-append="payment_provider_id" ${optionSelected == i ? 'selected' : ''}>`).text(paymentOptionCryptoTypes[i]);
                $('select#type').append(option);
            }
        } else {
            $('.blockchain_network_selector').attr('required', false);
            $('.blockchain_network_selector').parent().addClass('d-none');
            $('.online_banking_code_wrapper').removeClass('d-none');
            let optionSelected = $('input#oldPaymentOptionType').val();
            for(let i in paymentOptionTypes) {
                let option = '';
                if (i in paymentOptionCryptoTypes) {
                    option = $(`<option value="${i}" data-append="payment_provider_id" ${optionSelected ==  i ? 'selected' : ''}>`).text(paymentOptionCryptoTypes[i]);
                } else {
                    option = $(`<option value="${i}" ${$.inArray(i, localBankTypes) ? 'data-append="deposit_bank_id"' : ''} ${optionSelected ==  i ? 'selected' : ''}>`).text(paymentOptionTypes[i]);
                }
                $('select#type').append(option);
            }
        }

        if (blockchainNetWorks) {
            for(let i in blockchainNetWorks) {
                let option = $(`<option value="${data_get(blockchainNetWorks[i], 'network_code')}" ${selected !== '' && selected.includes(data_get(blockchainNetWorks[i], 'network_code')) ? 'selected' : ''} >`)
                            .text(data_get(blockchainNetWorks[i], 'name'));
                blockchainNetworkElement.append(option);
            }

        }
        reload = false;

        blockchainNetworkElement.selectpicker('refresh');
        $('select#type').selectpicker('refresh');
        $('select#type').trigger('change');
    }

    function reloadDependenceElement(currencyCode)
    {
        $('select#payment_provider_id').html('')
        $('select#deposit_bank_id').html('')

        let paymentProviderOptions = [];
        paymentProviders.filter(function(item) {
            return item?.supported_currencies?.includes(currencyCode);
        }).map(function(item) {
            let selected = $('input#oldPaymentProvider').val() == item.id;
            let params = JSON.stringify(item.params);

            let optionElement = $(`<option value="${item.id}" data-params='${params}'>`).text(item.name).prop('selected', selected);

            paymentProviderOptions.push(optionElement)
        });

        let depositBankOptions = [];

        banks.filter(function(item) {
            return item?.currency_code == currencyCode;
        }).map(function(item) {
            let selected = $('input#oldDepositBank').val() == item.id;
            let optionElement = $(`<option value="${item.id}">`).text(item.name).prop('selected', selected);

            depositBankOptions.push(optionElement)
        });

        $('select#payment_provider_id').append(paymentProviderOptions);
        $('select#deposit_bank_id').append(depositBankOptions);

        setTimeout(function(){
            $('select#payment_provider_id').selectpicker('refresh');
            $('select#deposit_bank_id').selectpicker('refresh');
        })
    }
</script>

<script>
    let paymentOptionAllowedCountryBadge = {
        iso2: null,
        name: null,
        parseFromObject: function(obj) {
            this.iso2 = obj?.iso2;
            this.name = obj?.name;

            return this;
        },
        render: function() {
            return $(`<button type="button" title="{{ __('Remove') }}" class="paymentOptionAllowedCountryBadgeSelected btn btn-sm btn-outline-brand btn-primary btn-right-icon mr-3 mb-3">`)
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
        $('form#store_payment_option').find('input[name="name"]').on('change keyup', function() {
            let nameVal = $(this).val();

            let nameValSlugify = nameVal?.trim()?.toLowerCase()?.replace(/[^\w-]+/g, '-');

            $('form#store_payment_option').find('input[name="slug"]').val(nameValSlugify);
        })

        $('select.payment_option_allow_country_selector').on('loaded.bs.select', function() {
            $(this).trigger('changed.bs.select');
        })

        $('select.payment_option_allow_country_selector').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            let $this = $(this)''
            let optionHolder = $(`.paymentOptionAllowedCountryOptionHolder`);
            let restrictionCountries = [];

            optionHolder.find('.paymentOptionAllowedCountryHolderContent').html('');

            $.each($this.val(), function(i, iso2) {
                let obj = {
                    iso2: $this.find(`option[value="${iso2}"]`).first().val(),
                    name: $this.find(`option[value="${iso2}"]`).first().data('country-name'),
                }

                restrictionCountries.push(obj);
            })

            if ($.isEmptyObject(restrictionCountries)) {
                optionHolder.find('.paymentOptionAllowedCountryHolderContent').html('');
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

            $(holderSelector).find('.paymentOptionAllowedCountryHolderContent').append(paymentOptionAllowedCountryBadge.parseFromObject(obj).render());
        }
    })

    $(document).on('click', '.paymentOptionAllowedCountryBadgeSelected', function() {
        let obj = {
            iso2: $(this).data('iso2'),
            name: $(this).data('name'),
        }

        let selector = $(`select.payment_option_allow_country_selector`);

        selector.find(`option[value="${obj.iso2}"]`).prop('selected', false);
        selector.trigger('changed.bs.select').selectpicker('render');
    })
</script>
@endsection
