@if($bonus->liability || ($bonus->wagering_requirement && $activeStep >= 5))
<div class="tab-pane" id="tab_liability" role="wizardpane">
    <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
        <div class="k-heading k-heading--md">{{ __('Liability') }}</div>
        <div class="k-separator k-separator--height-xs"></div>
        <div class="k-form__section k-form__section--first">
            <div class="form-group">
                <div class="k-checkbox-inline">
                    <label class="k-checkbox">
                        <input type="hidden" name="liability[limit_bonus][status]" value="0">
                        <input type="checkbox" name="liability[limit_bonus][status]" value="1"
                            {{ old('liability.limit_bonus.status', data_get($bonus->liability, 'limit_bonus.status', 0)) == 1 ? 'checked' : '' }}> {{ __('Limit bonus') }}
                        <span></span>
                    </label>
                </div>
            </div>

            <div id="liability_limit_bonus_active_section">
                @php
                    $liabilityCurrencies = $currencies;
                    $bonusAwardingBonusAwardType = old('awarding.bonus_award.type', data_get($bonus->awarding, 'bonus_award.type'));
                    $isBonusAmountSpecificCurrencyDistributionType = old(
                        "awarding.bonus_award.{$bonusAwardingBonusAwardType}.distribution_type",
                        data_get($bonus->awarding, "bonus_award.{$bonusAwardingBonusAwardType}.distribution_type")
                    ) == $awardingBonusAwardDistributionTypeEnum::SPECIFIC_CURRENCY;

                    if ($isBonusAmountSpecificCurrencyDistributionType) {
                        $bonusAmountSpecificCurrencyCode = old(
                            "awarding.bonus_award.{$bonusAwardingBonusAwardType}.specific_currency_code",
                            data_get($bonus->awarding, "bonus_award.{$bonusAwardingBonusAwardType}.specific_currency_code")
                        );

                        $liabilityCurrencies = $liabilityCurrencies->where('key', $bonusAmountSpecificCurrencyCode);
                    }
                @endphp
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label for="">{{ __('Total number of awarded bonus(es)') }}</label>
                        <input
                            type="number" class="form-control @error('liability.limit_bonus.total_number_awarded_bonus') is-invalid @enderror"
                            min="0"
                            value="{{ old("liability.limit_bonus.total_number_awarded_bonus", data_get($bonus->liability, "limit_bonus.total_number_awarded_bonus")) }}"
                            name="liability[limit_bonus][total_number_awarded_bonus]"
                            placeholder="{{ __('Total number of awarded bonus(es)') }}">
                        @error('liability.limit_bonus.total_number_awarded_bonus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                            @foreach($liabilityCurrencies->pluck('key') as $currency)
                            <li class="nav-item">
                                <a href="#liability_limit_bonus_amount_{{ $currency }}_section" class="nav-link {{ $loop->first ? 'active' : '' }} @error("liability.limit_bonus.currencies.$currency") is-invalid @enderror" data-toggle="tab" role="tab">{{ $currency }}</a>
                            </li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach($liabilityCurrencies->pluck('key') as $currency)
                            <div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="liability_limit_bonus_amount_{{ $currency }}_section" role="tabpanel">
                                <div class="form-group form-group-last row">
                                    <div class="col-lg-6 form-group-sub">
                                        <label for="">{{ __('Limit Amount') }} ({{ $currency }})</label>
                                        <x-currency-input
                                            name="liability[limit_bonus][currencies][{{ $currency }}]"
                                            currency="{{ $currency }}"
                                            class='form-control {{ $errors->has("liability.limit_bonus.currencies.{$currency}") ? "is-invalid" : "" }}'
                                            placeholder="{{ __('Limit Amount') }} ({{ $currency }})"
                                            value='{{ old("liability.limit_bonus.currencies.$currency", data_get($bonus->liability, "limit_bonus.currencies.{$currency}")) }}'
                                            default-min="false"
                                        />
                                        @error("liability.limit_bonus.currencies.{$currency}")
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
        </div>
    </div>
</div>
@endif
