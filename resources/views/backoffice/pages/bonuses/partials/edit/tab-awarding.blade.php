@if($bonus->awarding || ($bonus->eligibility && $activeStep >= 3))
<div class="tab-pane" id="tab_awarding" role="wizardpane">
    <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
        <div class="k-heading k-heading--md">{{ __('Awarding Type') }}</div>
        <div class="k-separator k-separator--height-xs"></div>
        <div class="k-form__section k-form__section--first">
            <div class="form-group">
                <label>{{ __('Awarding Type') }}</label>
                <div class="k-radio-inline @error('awarding.type') is-invalid @enderror">
                    @foreach($awardingTypeEnumLabels as $key => $label)
                    <label class="k-radio">
                        <input type="radio" {{ old('awarding.type', data_get($bonus->awarding, 'type', 1)) == $key ? 'checked' : '' }} name="awarding[type]" value="{{ $key }}" > {{ $label }}
                        <span></span>
                    </label>
                    @endforeach
                </div>
                @error('awarding.type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>{{ __('Multiple Instance') }}</label>
                <div class="k-checkbox-inline @error('awarding.multiple_instance') is-invalid @enderror">
                    <label class="k-checkbox">
                        <input type="hidden" name="awarding[multiple_instance]" value="0">
                        <input type="checkbox"
                            {{ old('awarding.multiple_instance', data_get($bonus->awarding, 'multiple_instance', 0)) == 1 ? 'checked' : '' }}
                            name="awarding[multiple_instance]"
                            value="1"> {{ __('Allow Multiple Instances of Bonus') }}
                        <span></span>
                    </label>
                </div>
                @error('awarding.multiple_instance')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div data-section-reference="multiple_instance" class="d-none">
                <div class="form-group">
                    <label>{{ __('Recurrence Selection') }}</label>
                    <div class="k-radio-inline @error('awarding.recurrence_type') is-invalid @enderror">
                        @foreach($recurrenceTypeEnumLabels as $key => $label)
                        <label class="k-radio">
                            <input type="radio" {{ old('awarding.recurrence_type', data_get($bonus->awarding, 'recurrence_type', 0)) == $key ? 'checked' : '' }} name="awarding[recurrence_type]" value="{{ $key }}" > {{ $label }}
                            <span></span>
                        </label>
                        @endforeach
                    </div>
                    @error('awarding.recurrence_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">{{ __('Recurrence Limit') }} *</label>
                    <div class="col-lg-4">
                        <input type="number" class="form-control @error('awarding.recurrence_limit') is-invalid @enderror" name="awarding[recurrence_limit]" value="{{ old('awarding.recurrence_limit', data_get($bonus->awarding, 'recurrence_limit')) }}">
                        @error('awarding.recurrence_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="k-heading k-heading--md">{{ __('Awarding Condition') }}</div>
            <div class="form-group">
                <select id="awarding_condition_type_select" class="form-control @error('awarding.condition.type') is-invalid @enderror" name="awarding[condition][type]">
                    @foreach ($awardingConditionTypeEnumLabels as $key => $label)
                        <option
                            value="{{ $key }}"
                            {{ old('awarding.condition.type', data_get($bonus->awarding, 'condition.type', 'deposit')) == $key ? 'selected' : '' }}
                        >{{ $label }}</option>
                    @endforeach
                    @error('awarding.condition.type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </select>
            </div>

            <!-- begin: Deposit section -->
            <div id="awarding_condition_type_deposit" class="awarding_condition_type_section {{ old('awarding.condition.type', 'deposit') == 'deposit' ? '' : 'd-none' }}">
                <div class="form-group">
                    <label>{{ __('Payment Options') }}</label>
                    <div class="form-group">
                        <select
                            id="awarding_condition_deposit_payment_option"
                            name="awarding[condition][deposit][payment_options][]"
                            multiple
                            data-size="5"
                            style="width: 100%"
                            data-live-search="true"
                            data-placeholder="{{ __('Select payment options or leave it empty to select all.') }}"
                            class="form-control k_selectpicker @anyerror('awarding.condition.deposit.payment_options, awarding.condition.deposit.payment_options.*') is-invalid @endanyerror"
                        >
                        @foreach($typeGroupedPaymentOptions as $typeName => $options)
                        <optgroup label="{{ $typeName }}">
                            @foreach ($options as $option)
                                @php
                                    $selected = false;
                                    $selectedOptions = old('awarding.condition.deposit.payment_options', data_get($bonus->awarding, 'condition.deposit.payment_options', []));
                                    $selected = in_array($option->id, $selectedOptions);
                                @endphp
                                <option {{ $selected ? 'selected' : '' }} value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="k-radio-list @error('awarding.condition.deposit.distribution_type') is-invalid @enderror">
                        @foreach ($awardingConditionDistributionTypeEnumLabels as $key => $label)
                            @if($awardingConditionDistributionTypeEnum::isDifferenceEachCurrency($key))
                            <label class="k-radio">
                                <input
                                    type="radio"
                                    {{ old('awarding.condition.deposit.distribution_type', data_get($bonus->awarding, 'condition.deposit.distribution_type', 0)) == $key ? 'checked' : '' }}
                                    name="awarding[condition][deposit][distribution_type]"
                                    class="awarding_condition_distribution_type_btn form-control @error("awarding.condition.deposit.currencies.at_least") is-invalid @enderror"
                                    data-condition-type="deposit"
                                    value="{{ $key }}"
                                >
                                {{ $label }}
                                <span></span>
                                @error("awarding.condition.deposit.currencies.at_least")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </label>

                            <div data-section-reference="awarding_condition_distribution_type" data-condition-type="deposit" data-distribution-type="{{ $key }}">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                            @foreach($currencies->pluck('key') as $currency)
                                            <li class="nav-item">
                                                <a
                                                    data-toggle="tab"
                                                    class="nav-link {{ $loop->first ? 'active' : '' }} @error("awarding.condition.deposit.currencies.{$currency}.*") is-invalid @enderror"
                                                    href="#deposit_{{ $currency }}_section" role="tab"
                                                >{{ $currency }}</a>
                                            </li>
                                            @endforeach
                                        </ul>

                                        <div class="tab-content">
                                            @foreach($currencies->pluck('key') as $currency)
                                            <div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="deposit_{{ $currency }}_section" role="tabpanel">
                                                <div class="form-group form-group-last row">
                                                    <div class="col-lg-6 form-group-sub">
                                                        <label for="">{{ __('Min Deposit') }} ({{ $currency }})</label>
                                                        <x-currency-input
                                                            name="awarding[condition][deposit][currencies][{{ $currency }}][min]"
                                                            currency="{{ $currency }}"
                                                            class='form-control {{ $errors->has("awarding.condition.deposit.currencies.$currency.min") ? "is-invalid" : "" }}'
                                                            placeholder="{{ __('Min Deposit') }}"
                                                            value='{{ old("awarding.condition.deposit.currencies.$currency.min", data_get($bonus->awarding, "condition.deposit.currencies.$currency.min")) }}'
                                                            data-identifier="min"
                                                            default-min="false"
                                                        />
                                                        @error("awarding.condition.deposit.currencies.{$currency}.min")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 form-group-sub">
                                                        <label for="">{{ __('Max Deposit') }} ({{ $currency }})</label>
                                                        <x-currency-input
                                                            name="awarding[condition][deposit][currencies][{{ $currency }}][max]"
                                                            currency="{{ $currency }}"
                                                            class='form-control {{ $errors->has("awarding.condition.deposit.currencies.$currency.max") ? "is-invalid" : "" }}'
                                                            placeholder="{{ __('Max Deposit') }}"
                                                            value='{{ old("awarding.condition.deposit.currencies.{$currency}.max", data_get($bonus->awarding, "condition.deposit.currencies.{$currency}.max")) }}'
                                                            data-identifier="max"
                                                            default-min="false"
                                                        />
                                                        @error("awarding.condition.deposit.currencies.{$currency}.max")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @elseif($awardingConditionDistributionTypeEnum::isAnyAmount($key))
                            <div>
                                <label class="k-radio">
                                    <input type="radio"
                                        {{ old('awarding.condition.deposit.distribution_type', data_get($bonus->awarding, 'condition.deposit.distribution_type', 0)) == $key ? 'checked' : '' }}
                                        name="awarding[condition][deposit][distribution_type]"
                                        data-condition-type="deposit"
                                        class="awarding_condition_distribution_type_btn"
                                        value="{{ $key }}"> {{ __('Any Amount') }}
                                    <span></span>
                                </label>
                            </div> --}}
                            @endif
                        @endforeach
                    </div>
                    @error('awarding.condition.deposit.distribution_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('Deposit Number') }}</label>
                    <div class="row">
                        <div class="col-lg-2">
                            <select class="form-control @error('awarding.condition.deposit.number.operator') is-invalid @enderror" name="awarding[condition][deposit][number][operator]">
                                <option {{ old('awarding.condition.deposit.number.operator', data_get($bonus->awarding, 'condition.deposit.number.operator', 'gt')) == 'gt' ? 'selected' : '' }} value="gt"> &gt; </option>
                                <option {{ old('awarding.condition.deposit.number.operator', data_get($bonus->awarding, 'condition.deposit.number.operator', 'gt')) == 'eq' ? 'selected' : '' }} value="eq"> = </option>
                            </select>
                            @error('awarding.condition.deposit.number.operator')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <input type="number" name="awarding[condition][deposit][number][value]" class="form-control @error('awarding.condition.deposit.number.value') is-invalid @enderror" placeholder="{{ __('Deposit Number') }}" value="{{ old('awarding.condition.deposit.number.value', data_get($bonus->awarding, 'condition.deposit.number.value', 0)) }}">
                            @error('awarding.condition.deposit.number.value')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- begin: Deposit section -->

            <!--begin: Signup section-->
            <div id="awarding_condition_type_signup" class="awarding_condition_type_section {{ old('awarding.condition.type', 'deposit') == 'signup' ? '' : 'd-none' }}">

            </div>
            <!--end: Signup section-->

            <!--begin: None section-->
            <div id="awarding_condition_type_none" class="awarding_condition_type_section {{ old('awarding.condition.type', 'deposit') == 'none' ? '' : 'd-none' }}">

            </div>
            <!--end: None section-->

            <div class="k-heading k-heading--md">{{ __('Bonus Amount Setup') }}</div>
            <div class="form-group">
                <label>{{ __('Award As') }}</label>
                <div class="k-radio-inline @error('awarding.bonus_award.type') is-invalid @enderror">
                    @foreach ($awardingBonusAwardTypeEnumLabels as $key => $label)
                    <label class="k-radio">
                        <input type="radio" {{ old('awarding.bonus_award.type', data_get($bonus->awarding, 'bonus_award.type', 'fixed')) == $key ? 'checked' : '' }} name="awarding[bonus_award][type]" value="{{ $key }}"> {{ $label }}
                        <span></span>
                    </label>
                    @endforeach
                </div>
                @error('awarding.bonus_award.type')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="k-radio-list @error('awarding.bonus_award.percent.distribution_type') is-invalid @enderror">
                <div data-section-reference="awarding_bonus_award_type" data-bonus-award-type="fixed">
                    <div class="form-group">
                        <div class="k-radio-list @error('awarding.bonus_award.fixed.distribution_type') is-invalid @enderror">
                            @foreach ($awardingBonusAwardDistributionTypeEnumLabels as $key => $label)
                                @if($awardingBonusAwardDistributionTypeEnum::isDifferenceEachCurrency($key))
                                <div>
                                    <label class="k-radio">
                                        <input
                                            {{ old('awarding.bonus_award.fixed.distribution_type', data_get($bonus->awarding, 'bonus_award.fixed.distribution_type', 0)) == $key ? 'checked' : '' }}
                                            type="radio"
                                            class="awarding_bonus_award_distribution_type_btn form-control @error('awarding.bonus_award.fixed.currencies.at_least') is-invalid @enderror"
                                            data-bonus-award-type="fixed"
                                            name="awarding[bonus_award][fixed][distribution_type]"
                                            value="{{ $key }}"> {{ $label }}
                                        <span></span>

                                        @error("awarding.bonus_award.fixed.currencies.at_least")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </label>
                                </div>
                                <div data-section-reference="awarding_bonus_award_distribution_type" data-bonus-award-type="fixed" data-distribution-type="{{ $key }}">
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                                @foreach($currencies->pluck('key') as $currency)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }} @error("awarding.bonus_award.fixed.currencies.$currency") is-invalid @enderror" data-toggle="tab" href="#bonus_award_fixed_{{ $currency }}_section" role="tab">{{ $currency }}</a>
                                                </li>
                                                @endforeach
                                            </ul>

                                            <div class="tab-content">
                                                @foreach($currencies->pluck('key') as $currency)
                                                <div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="bonus_award_fixed_{{ $currency }}_section" role="tabpanel">
                                                    <div class="form-group form-group-last row">
                                                        <div class="col-lg-6 form-group-sub">
                                                            <x-currency-input
                                                                name="awarding[bonus_award][fixed][currencies][{{ $currency }}]"
                                                                currency="{{ $currency }}"
                                                                class='form-control {{ $errors->has("awarding.bonus_award.fixed.currencies.$currency") ? "is-invalid" : "" }}'
                                                                value='{{ old("awarding.bonus_award.fixed.currencies.$currency", data_get($bonus->awarding, "bonus_award.fixed.currencies.$currency")) }}'
                                                                default-min="false"
                                                            />
                                                            @error("awarding.bonus_award.fixed.currencies.$currency")
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @elseif($awardingBonusAwardDistributionTypeEnum::isSpecificCurrency($key))
                                <div class="mb-3">
                                    <label class="k-radio">
                                        <input
                                            {{ old('awarding.bonus_award.fixed.distribution_type', data_get($bonus->awarding, 'bonus_award.fixed.distribution_type', 0)) == $key ? 'checked' : '' }}
                                            type="radio"
                                            class="awarding_bonus_award_distribution_type_btn"
                                            data-bonus-award-type="fixed"
                                            name="awarding[bonus_award][fixed][distribution_type]"
                                            value="{{ $key }}"> {{ $label }}
                                        <span></span>
                                    </label>
                                </div>
                                <div data-section-reference="awarding_bonus_award_distribution_type" data-bonus-award-type="fixed" data-distribution-type="{{ $key }}">
                                    <div class="form-group row">
                                        <div class="col-lg-12 row">
                                            @php
                                                $bonusAwardSpecificCurrencyCode = old('awarding.bonus_award.fixed.specific_currency_code', data_get($bonus->awarding, 'bonus_award.fixed.specific_currency_code'));
                                            @endphp
                                            <div class="col-lg-4">
                                                <select name="awarding[bonus_award][fixed][specific_currency_code]" class="form-control k_selectpicker {{ $errors->has('awarding.bonus_award.fixed.specific_currency_code') ? 'is-invalid' : '' }}">
                                                    @foreach ($currencies as $currency)
                                                        <option
                                                            {{ $bonusAwardSpecificCurrencyCode == $currency->getKey() ? 'selected' : '' }}
                                                            value="{{ $currency->getKey() }}"
                                                            data-subtext="{{ $currency->name }}">{{ $currency->getKey() }}</option>
                                                    @endforeach
                                                </select>
                                                @error("awarding.bonus_award.fixed.specific_currency_code")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-8">
                                                <input
                                                    id="bonus_award_specific_currency_value_input"
                                                    value="{{ old("awarding.bonus_award.fixed.currencies.{$bonusAwardSpecificCurrencyCode}", data_get($bonus->awarding, "bonus_award.fixed.currencies.{$bonusAwardSpecificCurrencyCode}")) }}"
                                                    type="text"
                                                    class="form-control {{ $errors->has('awarding.bonus_award.fixed.currencies.at_least') ? 'is-invalid' : '' }}"
                                                >
                                                @error('awarding.bonus_award.fixed.currencies.at_least')
                                                    <div class="invalid-feedback">{{ __('This field is required.') }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        @error('awarding.bonus_award.fixed.distribution_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div data-section-reference="awarding_bonus_award_type" data-bonus-award-type="percent">
                    <div class="form-group">
                        <label>{{ __('Percentage of Amount') }}</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <x-currency-input
                                        name="awarding[bonus_award][percent][value]"
                                        key="awarding[bonus_award][percent][value]"
                                        class="form-control {{ $errors->has('awarding.bonus_award.percent.value') ? 'is-invalid' : '' }}"
                                        placeholder="{{ __('Min Deposit') }}"
                                        value="{{ old('awarding.bonus_award.percent.value', data_get($bonus->awarding, 'bonus_award.percent.value', 0)) }}"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                    @error('awarding.bonus_award.percent.value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly data-label-reference="#awarding_condition_type_select">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Up to max amount') }}</label>
                        <br />
                        <div class="k-radio-list @error('awarding.bonus_award.percent.distribution_type') is-invalid @enderror">
                            @foreach ($awardingBonusAwardDistributionTypeEnumLabels as $key => $label)
                                @if($awardingBonusAwardDistributionTypeEnum::isDifferenceEachCurrency($key))
                                <div>
                                    <label class="k-radio">
                                        <input
                                            {{ old('awarding.bonus_award.percent.distribution_type', data_get($bonus->awarding, 'bonus_award.percent.distribution_type', 0)) == $key ? 'checked' : '' }}
                                            type="radio"
                                            min="0"
                                            class="awarding_bonus_award_distribution_type_btn"
                                            data-bonus-award-type="percent"
                                            name="awarding[bonus_award][percent][distribution_type]"
                                            value="{{ $key }}"> {{ $label }}
                                        <span></span>
                                    </label>
                                </div>
                                <div data-section-reference="awarding_bonus_award_distribution_type" data-bonus-award-type="percent" data-distribution-type="{{ $key }}">
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                                @foreach($currencies->pluck('key') as $currency)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }} @error("awarding.bonus_award.percent.currencies.{$currency}") is-invalid @enderror" data-toggle="tab" href="#bonus_award_percent_{{ $currency }}_section" role="tab">{{ $currency }}</a>
                                                </li>
                                                @endforeach
                                            </ul>

                                            <div class="tab-content">
                                                @foreach($currencies->pluck('key') as $currency)
                                                <div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="bonus_award_percent_{{ $currency }}_section" role="tabpanel">
                                                    <div class="form-group form-group-last row">
                                                        <div class="col-lg-6 form-group-sub">
                                                            <x-currency-input
                                                                currency="{{ $currency }}"
                                                                name="awarding[bonus_award][percent][currencies][{{ $currency }}]"
                                                                class='form-control {{ $errors->has("awarding.bonus_award.percent.currencies.{$currency}") ? "is-invalid" : "" }}'
                                                                value='{{ old("awarding.bonus_award.percent.currencies.{$currency}", data_get($bonus->awarding, "bonus_award.percent.currencies.{$currency}")) }}'
                                                                default-min="false"
                                                            />
                                                            @error("awarding.bonus_award.percent.currencies.{$currency}")
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        @error('awarding.bonus_award.percent.distribution_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            @error('awarding.bonus_award.percent.distribution_type')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@endif
