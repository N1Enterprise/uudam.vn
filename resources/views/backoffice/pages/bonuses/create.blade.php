@extends('backoffice.layouts.master')

@php
	$title = 'Bonuses';

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Create New Bonus'),
		]
	];
@endphp

@section('header')
{{ $title }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<form id="form_store_bonus" action="{{ route('bo.web.bonuses.store') }}" method="POST">
    @csrf
    <div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
        <div class="k-portlet">
            @error('*')
                {{-- @php
                    dd($messages);
                    dd($errors->getBag('default'));
                @endphp --}}
            <div class="alert alert-danger fade show" role="alert">
                <div class="alert-text">
                    <ul>
                        <li>{{ __('Submit failed. Please check the error below.') }}</li>
                    </ul>
                </div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
            @enderror
            <div class="k-portlet__body k-portlet__body--fit">
                <div class="k-wizard-v3" data-kwizard-state="first">
                    <!--begin: Form Wizard Nav -->
                    <div class="k-wizard-v3__nav">
                        <div class="k-wizard-v3__nav-line"></div>
                        <div class="k-wizard-v3__nav-items" role="wizardstep">
                            <a href="#tab_general" class="k-wizard-v3__nav-item @anyerror('code,name,game_product_type,category,start_at,end_at,redeem_bonus_in,expire_at,status,description,promotion_code') is-invalid @endanyerror" data-toggle="wizardtab" aria-selected="true" data-kwizard-state="current" data-wizard-locked="false" data-wizard-step="1">
                                <span>1</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('General') }}</div>
                            </a>
                            <a href="#tab_eligibility" class="k-wizard-v3__nav-item" data-toggle="wizardtab" data-kwizard-state="pending" data-wizard-step="2" data-wizard-locked="false">
                                <span>2</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('Eligibility') }}</div>
                            </a>
                            <a href="#tab_awarding" class="k-wizard-v3__nav-item" data-kwizard-type="step" data-toggle="wizardtab" data-kwizard-state="pending" data-wizard-step="3" data-wizard-locked="true">
                                <span>3</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('Awarding') }}</div>
                            </a>
                            <a href="#tab_wagering_requirement" class="k-wizard-v3__nav-item" data-kwizard-type="step" data-toggle="wizardtab" data-kwizard-state="pending" data-wizard-step="4" data-wizard-locked="true">
                                <span>4</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('Wagering Requirement') }}</div>
                            </a>
                            <a href="#tab_liability" class="k-wizard-v3__nav-item" data-kwizard-type="step" data-toggle="wizardtab" data-kwizard-state="pending" data-wizard-step="4" data-wizard-locked="true">
                                <span>5</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('Liability') }}</div>
                            </a>
                        </div>
                    </div>
                    <!--end: Form Wizard Nav -->

                    <div class="k-form">
                        <div class="tab-content">
                            <div id="tab_general" class="tab-pane active show" role="wizardpane">
                                <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
                                    <div class="k-heading k-heading--md">{{ __('General Information') }}</div>
                                    <div class="k-separator k-separator--height-xs"></div>
                                    <div class="k-form__section k-form__section--first">
                                        <div class="form-group">
                                            <label>{{ __('Code') }} *</label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required>
                                            @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Name') }} *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Category') }} *</label>
                                            <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                                @foreach($bonusCategoryEnumLabels as $key => $label)
                                                <option {{ old('category') == $key ? 'selected' : '' }} value="{{ $key }}">{{ $label }}</option>
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
                                                    <input type="datetimepicker" class="form-control @error('start_at') is-invalid @enderror" name="start_at" value="{{ old('start_at') }}" required>
                                                    @error('start_at')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ __('End') }}</label>
                                                    <input type="datetimepicker" class="form-control @error('end_at') is-invalid @enderror" name="end_at" value="{{ old('end_at') }}">
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
                                                        <input type="number" min="0" class="form-control @error('redeem_bonus_in') is-invalid @enderror" value="{{ old('redeem_bonus_in') }}" name="redeem_bonus_in">
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
                                                    <input type="datetimepicker" class="form-control @error('expire_at') is-invalid @enderror" name="expire_at" value="{{ old('expire_at') }}">
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
                                                    <input type="radio" {{ old('status', 0) == $key ? 'checked' : '' }} name="status" value="{{ $key }}" > {{ $status }}
                                                    <span></span>
                                                </label>
                                                @endforeach
                                            </div>
                                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Description') }} *</label>
                                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" spellcheck="false" style="margin-top: 0px; margin-bottom: 0px; height: 85px;">{{ old('description') }}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Promotion Code') }} *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control @error('promotion_code') is-invalid @enderror" name="promotion_code" value="{{ old('promotion_code') }}" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-brand" id="random_promotion_code" type="button">{{ __('Random Code') }}</button>
                                                </div>
                                                @error('promotion_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="tab_eligibility" class="tab-pane"role="wizardpane">
                                <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
                                    <div class="k-heading k-heading--md">{{ __('Eligibility') }}</div>
                                    <div class="k-separator k-separator--height-xs"></div>
                                    <div class="k-form__section k-form__section--first"></div>
                                </div>
                            </div>

                            <div id="tab_awarding" class="tab-pane" role="wizardpane">
                                <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
                                    <div class="k-heading k-heading--md">{{ __('Awarding Type') }}</div>
                                    <div class="k-separator k-separator--height-xs"></div>
                                    <div class="k-form__section k-form__section--first"></div>
                                </div>
                            </div>

                            <div id="tab_wageringRequirement" class="tab-pane" role="wizardpane">
                                <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
                                    <div class="k-heading k-heading--md">{{ __('Wagering Requirement') }}</div>
                                    <div class="k-separator k-separator--height-xs"></div>
                                    <div class="k-form__section k-form__section--first"></div>
                                </div>
                            </div>

                            <div id="tab_liability" class="tab-pane" role="wizardpane">
                                <div class="k-wizard-v3__content" data-kwizard-type="step-content" data-kwizard-state="current">
                                    <div class="k-heading k-heading--md">{{ __('Liability') }}</div>
                                    <div class="k-separator k-separator--height-xs"></div>
                                    <div class="k-form__section k-form__section--first"></div>
                                </div>
                            </div>
                        </div>

                        <!--begin: Form Actions -->
                        <div class="k-form__actions">
                            <div>
                                <button type="submit" class="d-none">{{ __('Submit') }}</button>
                                <button type="redirect" data-request-url="{{ route('bo.web.bonuses.index') }}" class="btn btn-secondary" data-wizard-action="cancel">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-wide" data-wizard-action="next">
                                    {{ __('Next') }}
                                </button>
                            </div>
                        </div>
                        <!--end: Form Actions -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js_script')
<script type="text/javascript">
    $(document).ready(function() {
        activeWizardStep(
            $('[role=wizardstep] a[data-toggle=wizardtab][data-wizard-locked="false"]').first()
        );

        $('[role=wizardstep] a[data-toggle=wizardtab]').on('click', function(e) {
            e.preventDefault();

            if ($(this).data('wizard-locked') == true) {
                alert("{{ __('Please submit previous step first.') }}");
            } else {
                $('form#form_store_bonus').first().submit();
            }
        });

        $('button[data-wizard-action="next"]').on('click', function() {
            $('form#form_store_bonus').first().submit();
        });

        $("#random_promotion_code").on('click', function () {
            let input = $('input[name="promotion_code"]');
            input.prop('type', 'text');
            input.val(Math.random().toString(36).slice(6));
        });

        $('form#form_store_bonus').on('submit', function() {
            $('.k-form__actions button').prop('disabled', true);
        });
    });

    function activeWizardStep(elementSelection) {
        $('[role=wizardstep] a[data-toggle=wizardtab]').attr('data-kwizard-state', 'pending');
        $(elementSelection).attr('data-kwizard-state', 'current');
        $('[role=wizardpane]').removeClass('active show');
        let tabSelection = $(elementSelection).attr('href');
        $('.actionBtn[data-wizard-action=save]').attr('data-wizard-step', tabSelection);
        $(tabSelection).addClass('active show');
    }
</script>
@endsection
