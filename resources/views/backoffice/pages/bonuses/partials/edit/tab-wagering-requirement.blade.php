@if($bonus->wagering_requirement || ($bonus->awarding && $activeStep >= 4))
<div class="tab-pane" id="tab_wageringRequirement" role="wizardpane">
    <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
        <div class="k-heading k-heading--md">{{ __('Wagering Requirement') }}</div>
        <div class="k-separator k-separator--height-xs"></div>
        <div class="k-form__section k-form__section--first">
            <div class="form-group">
                <div class="k-checkbox-inline">
                    <label class="k-checkbox">
                        <input type="hidden" name="wagering_requirement[status]" value="0">
                        <input type="checkbox" name="wagering_requirement[status]" value="1" {{ old('wagering_requirement.status', data_get($bonus->wagering_requirement, 'status', 0)) == 1 ? 'checked' : '' }}> {{ __('Bonus has wagering requirement') }}
                        <span></span>
                    </label>
                </div>
            </div>

            <div id="wagering_requirement_active_section">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label>{{ __('Wagering Multiplier') }}</label>
                        <x-currency-input
                            key="wagering_requirement[multiplier]"
                            class="form-control {{ $errors->has('wagering_requirement.multiplier') ? 'is-invalid' : '' }}"
                            name="wagering_requirement[multiplier]"
                            allow-minus="false"
                            value="{{ old('wagering_requirement.multiplier', round_money(data_get($bonus->wagering_requirement, 'multiplier', 1))) }}"
                        />
                        @error('wagering_requirement.multiplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6 wagering_requirement_multiplier">
                        <label>{{ __('Multiply To') }}</label>
                        <select name="wagering_requirement[multiply_type]" class="form-control @error('wagering_requirement.multiply_type') is-invalid @enderror">
                            @foreach($wageringRequirementMultiplyTypeEnum::labelsByAwardingConditionType(old('awarding.condition.type', data_get($bonus->awarding, 'condition.type', 'deposit'))) as $key => $label)
                            <option
                                {{ old('wagering_requirement.multiply_type', data_get($bonus->wagering_requirement, 'multiply_type', 1)) == $key ? 'selected' : ''  }}
                                value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('wagering_requirement.multiply_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
