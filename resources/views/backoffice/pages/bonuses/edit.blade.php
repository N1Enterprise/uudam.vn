@extends('backoffice.layouts.master')

@php
	$title = __('Bonuses');

	$breadcrumbs = [
		[
			'label' => $title,
            'href'  => route('bo.web.bonuses.index')
		],
		[
			'label' => __('Edit Bonus'),
		]
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<form id="form_update_bonus" novalidate action="{{ route('bo.web.bonuses.update', $bonus->getKey()) }}" method="POST">
    @csrf
    @method('PUT')

    @php
        $activeStep  = request()->query('step', -1);
        $stepMappers = [
            1 => 'id',
            2 => 'eligibility',
            3 => 'awarding',
            4 => 'wagering_requirement',
            5 => 'liability',
        ];

        if ($activeStep == -1) {
            collect($stepMappers)->each(function($stepName, $stepNumber) use ($bonus, &$activeStep) {
                if ($bonus->{$stepName} == null) {
                    $activeStep = $stepNumber;

                    return false;
                }
            });
        }
    @endphp

    <input type="hidden" name="active_step" value="{{ $activeStep }}">
    <input type="hidden" name="is_bonus_finished" value="{{ $bonus->isFinished() ? '1' : '0' }}">
    <input type="hidden" name="next_step" value="{{ $activeStep < count($stepMappers) ? $activeStep : '' }}">
    <input type="hidden" name="is_bonus_expired" value="{{ $bonus->isExpired() ? '1' : '0' }}">
    <input type="hidden" name="is_bonus_view_mode" value="{{ isset($viewOnly) ? $viewOnly : false; }}">

    <div class="k-content__body	k-id__item k-grid__item--fluid" id="k_content_body">
        <div class="k-portlet">
            @error('*')
            @php
                // dd($errors);
            @endphp
            <div class="alert alert-danger fade show" role="alert">
                <div class="alert-text">
                    <ul>
                        <li>{{ __('Submit failed. Please check the error below.') }}</li>
                    </ul>
                </div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="la la-close"></i>
                        </span>
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
                            <a href="#tab_general" class="k-wizard-v3__nav-item {{ $bonus->isFinished() ? 'active' : '' }} @anyerror('code,name,game_product_type,category,start_at,end_at,redeem_bonus_in,expire_at,status,description,promotion_code') is-invalid @endanyerror" data-toggle="wizardtab" aria-selected="true" data-step-name="general" data-wizard-fowarded="true" data-kwizard-state="pending" data-wizard-step="1" data-wizard-locked="false">
                                <span>1</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('General') }}</div>
                            </a>
                            <a href="#tab_eligibility" class="k-wizard-v3__nav-item @error('eligibility.*') is-invalid @enderror" data-toggle="wizardtab" data-lock-message="{{ __('Please submit previous step first.') }}" data-step-name="eligibility" data-wizard-fowarded="true" data-kwizard-state="pending" data-wizard-step="2" data-wizard-locked="false">
                                <span>2</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('Eligibility') }}</div>
                            </a>
                            <a href="#tab_awarding" class="k-wizard-v3__nav-item @error('awarding.*') is-invalid @enderror" data-kwizard-type="step" data-toggle="wizardtab" data-lock-message="{{ __('Please submit previous step first.') }}" data-step-name="awarding"  data-kwizard-state="pending" data-wizard-step="3" data-wizard-fowarded="true" data-wizard-locked="{{ $bonus->eligibility ? 'false' : 'true' }}">
                                <span>3</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('Awarding') }}</div>
                            </a>
                            <a href="#tab_wageringRequirement" class="k-wizard-v3__nav-item @error('wagering_requirement.*') is-invalid @enderror" data-kwizard-type="step" data-toggle="wizardtab" data-lock-message="{{ __('Please submit previous step first.') }}" data-step-name="wagering_requirement" data-wizard-fowarded="{{ $bonus->awarding || ($bonus->eligibility && $activeStep >= 3) ? 'true' : 'false' }}" data-kwizard-state="pending" data-wizard-step="4" data-wizard-locked="{{ $bonus->awarding ? 'false' : 'true' }}">
                                <span>4</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('Wagering Requirement') }}</div>
                            </a>
                            <a href="#tab_liability" class="k-wizard-v3__nav-item @error('liability.*') is-invalid @enderror" data-kwizard-type="step" data-toggle="wizardtab" data-lock-message="{{ __('Please submit previous step first.') }}" data-step-name="liability" data-wizard-fowarded="{{ $bonus->wagering_requirement || ($bonus->awarding && $activeStep >= 4) ? 'true' : 'false' }}" data-kwizard-state="pending" data-wizard-step="5" data-wizard-locked="{{ $bonus->wagering_requirement ? 'false' : 'true' }}">
                                <span>5</span>
                                <i class="fa fa-check"></i>
                                <div class="k-wizard-v3__nav-label">{{ __('Liability') }}</div>
                            </a>
                        </div>
                    </div>
                    <!--end: Form Wizard Nav -->

                    <!--start: Form Wizard Content -->
                    <div class="k-form">
                        <div class="tab-content">
                            @include('backoffice.pages.bonuses.partials.edit.tab-general')
                            @include('backoffice.pages.bonuses.partials.edit.tab-eligibility')
                            @include('backoffice.pages.bonuses.partials.edit.tab-awarding')
                            @include('backoffice.pages.bonuses.partials.edit.tab-wagering-requirement')
                            @include('backoffice.pages.bonuses.partials.edit.tab-liability')
                        </div>

                        <!--begin: Form Wizard Actions -->
                        <div class="k-form__actions">
                            <div>
                                @if($activeStep == 5)
                                <div class="d-none">
                                    <button type="submit" data-wizard-action="submit">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                                @else
                                <button type="submit" class="d-none">{{ __('Submit') }}</button>
                                @endif
                                <button type="redirect" data-request-url="{{ route('bo.web.bonuses.index') }}" class="btn btn-secondary d-none" data-wizard-action="cancel">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-wide d-none" data-wizard-action="previous">
                                    {{ __('Previous') }}
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-wide d-none" data-wizard-action="next">
                                    {{ __('Next') }}
                                </button>
                                <button type="submit" class="btn btn-primary btn-wide k-font-bold k-font-transform-u d-none" data-wizard-action="submit">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                        <!--begin: Form Wizard Actions -->
                    </div>
                    <!--end: Form Wizard -->
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js_script')
<script src="{{ asset('js/sportsbook/odds_converter.js') }}" type="text/javascript"></script>
@include('backoffice.pages.bonuses.js-pages.edit-script')
@endsection
