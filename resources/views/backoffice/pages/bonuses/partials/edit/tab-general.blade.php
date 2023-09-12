<div class="tab-pane" id="tab_general" role="wizardpane">
    <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
        <div class="k-heading k-heading--md">{{ __('General Information') }}</div>
        <div class="k-separator k-separator--height-xs"></div>
        <div class="k-form__section k-form__section--first">
            <div class="form-group">
                <label>{{ __('Code') }} *</label>
                <input required type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $bonus->code) }}">
                @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>{{ __('Name') }} *</label>
                <input required type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $bonus->name) }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>{{ __('Category') }} *</label>
                <select required name="category" class="form-control @error('category') is-invalid @enderror">
                    @foreach($bonusCategoryEnumLabels as $key => $label)
                        <option {{ old('category', $bonus->category) == $key ? 'selected' : '' }} value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>{{ __('Start') }} *</label>
                        <input required type="datetimepicker" class="form-control @error('start_at') is-invalid @enderror" name="start_at" value="{{ substr(old('start_at', $bonus->start_at), 0, 16) }}">
                        @error('start_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>{{ __('End') }}</label>
                        <input type="datetimepicker" class="form-control @error('end_at') is-invalid @enderror" name="end_at" value="{{ substr(old('end_at', $bonus->end_at), 0, 16) }}">
                        @error('end_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>{{ __('Redeem Bonus In') }}</label>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control @error('redeem_bonus_in') is-invalid @enderror" name="redeem_bonus_in" value="{{ old('redeem_bonus_in', $bonus->redeem_bonus_in) }}">
                            <div class="input-group-append">
                                <span class="input-group-text">{{ __('days') }}</span>
                            </div>
                            @error('redeem_bonus_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>{{ __('Expire On') }}</label>
                        <input type="datetimepicker" class="form-control @error('expire_at') is-invalid @enderror" name="expire_at" value="{{ substr(old('expire_at', $bonus->expire_at), 0, 16) }}">
                        @error('expire_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>{{ __('Status') }} *</label>
                <div class="k-radio-inline @error('status') is-invalid @enderror">
                    @foreach($bonusStatusEnumLabels as $key => $status)
                    <label class="k-radio">
                        <input required type="radio" {{ old('status', $bonus->status) == $key ? 'checked' : '' }} name="status" value="{{ $key }}">
                        {{ $status }}
                        <span></span>
                    </label>
                    @endforeach
                </div>
                @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>{{ __('Description') }} *</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" spellcheck="false" style="margin-top: 0px; margin-bottom: 0px; height: 85px;">{{ old('description', $bonus->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>{{ __('Promotion Code') }} *</label>
                <div class="input-group">
                    <input required type="text" class="form-control @error('promotion_code') is-invalid @enderror" name="promotion_code" value="{{ old('promotion_code', $bonus->promotion_code) }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-brand" id="randomPromotionCode" type="button">{{ __('Random Code') }}</button>
                    </div>

                    @error('promotion_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
