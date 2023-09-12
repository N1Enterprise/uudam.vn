<div class="tab-pane" id="tab_eligibility" role="wizardpane">
    <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
        <div class="k-heading k-heading--md">{{ __('Eligibility') }}</div>
        <div class="k-separator k-separator--height-xs"></div>
        <div class="k-form__section k-form__section--first">
            <div class="form-group">
                <label>{{ __('Currencies') }} *</label>
                <div class="k-checkbox-inline @anyerror('eligibility.currencies, eligibility.currencies.*') is-invalid @endanyerror">
                    @foreach ($eligibilityCurrencies->pluck('key') as $currency)
                    @php
                        $oldEligibilityCurrencies = old('eligibility.currencies', $bonus->eligibility['currencies'] ?? [$currency]);

                        if ($errors->has('eligibility.currencies')) {
                            $oldEligibilityCurrencies = old('eligibility.currencies', []);
                        }
                    @endphp
                    <label class="k-checkbox">
                        <input type="checkbox" class="form-control" {{ in_array($currency, $oldEligibilityCurrencies) ? 'checked' : '' }} name="eligibility[currencies][]" value="{{ $currency }}">
                        <small>{{ $currency }}</small>
                        <span></span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
