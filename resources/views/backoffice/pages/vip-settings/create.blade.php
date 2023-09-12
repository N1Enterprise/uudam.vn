@extends('backoffice.layouts.master')

@php
    $title = 'Create New VIP';

    $breadcrumbs = [
        [
            'label' => 'User',
        ],
        [
            'label' => 'VIP Setting',
            'href'  => route('bo.web.vip-settings.index')
        ],
        [
            'label' => $title,
        ],
    ];
@endphp

@section('header')
    {{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="k-portlet">
                <div class="k-portlet__head">
                    <div class="k-portlet__head-label">
                        <h3 class="k-portlet__head-title">{{ $title }}</h3>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="k-form k-form--label-right" id="store_vip_setting" method="post" action="{{ route('bo.web.vip-settings.store') }}">
                    @csrf
                    <div class="k-portlet__body">
                        @include('backoffice.partials.message')

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>{{ __('VIP Level') }} *</label>
                                <input type="number" min="1" class="form-control" id="vip_level" name="vip_level" placeholder="{{ __('Enter VIP Level') }}" value="{{ old('vip_level') }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="">{{ __('VIP Name') }} *</label>
                                <input type="text" class="form-control" id="vip_name" name="vip_name" placeholder="{{ __('Enter VIP name') }}" value="{{ old('vip_name') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
							<label class="col-1 col-form-label text-left">{{ __('Status') }}</label>
							<div class="col-2">
								<span class="k-switch">
									<label>
										<input type="checkbox" {{ old('status') == 'on' ? 'checked' : '' }} name="status" />
										<span></span>
									</label>
								</span>
							</div>
						</div>

                        <div class="k-heading k-heading--md">{{ __('Deposit Limit Setting') }}</div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label class="">{{ __('Deposit Limit Per Transaction') }}</label>
                                <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                    @foreach ($currencies as $currency)
                                        @php $row = $currency->getKey(); @endphp
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#deposit_limit_per_transaction_{{ $row }}" role="tab">{{ $row }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach ($currencies as $currency)
                                        @php $row = $currency->getKey(); @endphp
                                        <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="deposit_limit_per_transaction_{{ $row }}" role="tabpanel">
                                            <div class="form-group form-group-last row">
                                                <div class="col-lg-6 form-group-sub">
                                                    <input
                                                        type="number" class="form-control"
                                                        id="min_deposit_per_transaction_{{ $row }}"
                                                        name="min_deposit_per_transaction[{{ $row }}]"
                                                        value="{{ old("min_deposit_per_transaction.{$row}") }}"
                                                        placeholder="{{ __('Min Deposit') }}" min="0">
                                                </div>
                                                <div class="col-lg-6 form-group-sub">
                                                    <input
                                                        type="number" class="form-control"
                                                        id="max_deposit_per_transaction_{{ $row }}"
                                                        name="max_deposit_per_transaction[{{ $row }}]"
                                                        value="{{ old("max_deposit_per_transaction.{$row}") }}"
                                                        placeholder="{{ __('Max Deposit') }}" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="">{{ __('Deposit Limit Daily') }}</label>
                                <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                    @foreach ($currencies as $currency)
                                        @php  $row = $currency->getKey(); @endphp
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#deposit_limit_per_daily_{{ $row }}" role="tab">{{ $row }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach ($currencies as $currency)
                                        @php $row = $currency->getKey(); @endphp
                                        <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="deposit_limit_per_daily_{{ $row }}" role="tabpanel">
                                            <div class="form-group form-group-last row">
                                                <div class="col-lg-6 form-group-sub">
                                                    <input
                                                        type="number" class="form-control"
                                                        id="min_deposit_per_daily_{{ $row }}"
                                                        name="min_deposit_per_daily[{{ $row }}]"
                                                        value="{{ old("min_deposit_per_daily.{$row}") }}"
                                                        placeholder="{{ __('Min Deposit') }}" min="0">
                                                </div>
                                                <div class="col-lg-6 form-group-sub">
                                                    <input
                                                        type="number" class="form-control"
                                                        id="max_deposit_per_daily_{{ $row }}"
                                                        name="max_deposit_per_daily[{{ $row }}]"
                                                        value="{{ old("max_deposit_per_daily.{$row}") }}"
                                                        placeholder="{{ __('Max Deposit') }}" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="k-heading k-heading--md">{{__('Withdraw Limit Setting')}}</div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label class="">{{__('Max Withdraw Per Transaction')}}</label>
                                <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                    @foreach ($currencies as $currency)
                                        @php $row = $currency->getKey(); @endphp
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#max_withdraw_per_transaction_{{ $row }}" role="tab">{{ $row }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach ($currencies as $currency)
                                        @php $row = $currency->getKey(); @endphp
                                        <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="max_withdraw_per_transaction_{{ $row }}" role="tabpanel">
                                            <input
                                                type="number" class="form-control"
                                                id="max_withdraw_per_transaction_{{ $row }}"
                                                name="max_withdraw_per_transaction[{{ $row }}]"
                                                value="{{ old("max_withdraw_per_transaction.{$row}") }}"
                                                placeholder="{{ __('Max Withdraw Per Transaction') }}" min="0">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="">{{__('Max Withdraw Limit Daily')}}</label>
                                <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                    @foreach ($currencies as $currency)
                                        @php $row = $currency->getKey(); @endphp
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#max_withdraw_per_daily_{{ $row }}" role="tab">{{ $row }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($currencies as $currency)
                                        @php $row = $currency->getKey(); @endphp
                                        <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="max_withdraw_per_daily_{{ $row }}" role="tabpanel">
                                            <input
                                                type="number" class="form-control"
                                                id="max_withdraw_per_daily_{{ $row }}"
                                                name="max_withdraw_per_daily[{{ $row }}]"
                                                value="{{ old("max_withdraw_per_daily.$row") }}"
                                                placeholder="{{ __('Max Withdraw Limit Daily') }}" min="0">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="k-heading k-heading--md">{{__('VIP Level Requirements')}}</div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label class="">{{__('Upgrade Requirements')}}</label>
                                <div class="col-lg-12 border border-secondary p-3 mt-4">
                                    <div class="box-title col-lg-3 col-md-3 col-sm-4" style="transform: translateY(-30px)">
                                        <select name="upgrade_requirement[operator]" class="form-control">
                                            <option {{ old("upgrade_requirement.operator") == 'and' ? 'selected' : '' }} value="and">{{ __('AND') }}</option>
                                            <option {{ old("upgrade_requirement.operator") == 'or' ? 'selected' : '' }} value="or">{{ __('OR') }}</option>
                                        </select>
                                    </div>

                                    <div class="box-content">
                                        <div class="form-group">
                                            <label for="">{{ __('Point') }} >=</label>
                                            <input
                                                type="number"
                                                class="form-control"
                                                name="upgrade_requirement[point]"
                                                value="{{ old("upgrade_requirement.point") }}"
                                                placeholder="{{ __('Point') }}" min="0.01" step="0.01">
                                        </div>

                                        <div class="form-group">
                                            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                                @foreach ($fiatCurrencies as $currency)
                                                    @php $row = $currency->getKey(); @endphp
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#upgrade_requirement_bet_deposit_amount_tab_{{ $row }}" role="tab">{{ $row }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($fiatCurrencies as $currency)
                                                    @php $row = $currency->getKey(); @endphp
                                                    <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="upgrade_requirement_bet_deposit_amount_tab_{{ $row }}" role="tabpanel">
                                                        <div class="form-group">
                                                            <label for="">{{ __('Bet Amount') }} >=</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">{{ data_get($currency, 'symbol') }}</span>
                                                                </div>
                                                                <input
                                                                    type="number"
                                                                    class="form-control"
                                                                    name="upgrade_requirement[currencies][{{ $row }}][bet_amount]"
                                                                    value="{{ old("upgrade_requirement.currencies.{$row}.bet_amount") }}"
                                                                    placeholder="{{ __('Bet Amount') }}" min="0.01" step="0.01">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Deposit Amount') }} >=</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">{{ data_get($currency, 'symbol') }}</span>
                                                                </div>
                                                                <input
                                                                    type="number"
                                                                    class="form-control"
                                                                    name="upgrade_requirement[currencies][{{ $row }}][deposit_amount]"
                                                                    value="{{ old("upgrade_requirement.currencies.{$row}.deposit_amount") }}"
                                                                    placeholder="{{ __('Deposit Amount') }}" min="0.01" step="0.01">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="">{{ __('Maintain Requirements') }}</label>
                                <div class="col-lg-12 border border-secondary p-3 mt-4">
                                    <div class="box-title col-lg-3 col-md-3 col-sm-4" style="transform: translateY(-30px)">
                                        <select name="maintain_requirement[operator]" class="form-control">
                                            <option {{ old("maintain_requirement.operator") == 'and' ? 'selected' : '' }} value="and">{{ __('AND') }}</option>
                                            <option {{ old("maintain_requirement.operator") == 'or' ? 'selected' : '' }} value="or">{{ __('OR') }}</option>
                                        </select>
                                    </div>
                                    <div class="box-content">
                                        <div class="form-group">
                                            <label for="">{{ __('Point') }} >=</label>
                                            <input
                                                type="number"
                                                class="form-control"
                                                name="maintain_requirement[point]"
                                                value="{{ old("maintain_requirement.point") }}"
                                                placeholder="{{ __('Point') }}" min="0.01" step="0.01">
                                        </div>
                                        <div class="form-group">
                                            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                                @foreach ($fiatCurrencies as $currency)
                                                    @php $row = $currency->getKey(); @endphp
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#maintain_requirement_bet_deposit_amount_tab_{{ $row }}" role="tab">{{ $row }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($fiatCurrencies as $currency)
                                                    @php $row = $currency->getKey(); @endphp
                                                    <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="maintain_requirement_bet_deposit_amount_tab_{{ $row }}" role="tabpanel">
                                                        <div class="form-group">
                                                            <label for="">{{ __('Bet Amount') }} >=</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">{{ data_get($currency, 'symbol') }}</span>
                                                                </div>
                                                                <input
                                                                    type="number"
                                                                    class="form-control"
                                                                    name="maintain_requirement[currencies][{{ $row }}][bet_amount]"
                                                                    value="{{ old("maintain_requirement.currencies.{$row}.bet_amount") }}"
                                                                    placeholder="{{ __('Bet Amount') }}" min="0.01" step="0.01">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{ __('Deposit Amount') }} >=</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">{{ data_get($currency, 'symbol') }}</span>
                                                                </div>
                                                                <input
                                                                    type="number"
                                                                    class="form-control"
                                                                    name="maintain_requirement[currencies][{{ $row }}][deposit_amount]"
                                                                    value="{{ old("maintain_requirement.currencies.{$row}.deposit_amount") }}"
                                                                    placeholder="{{ __('Deposit Amount') }}" min="0.01" step="0.01">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">{{__('Period of Time')}}</label>
                                            <div class="input-group">
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    name="time_period"
                                                    value="{{ old("time_period") }}"
                                                    placeholder="{{ __('Month') }}" min="1" step="1" max="12">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">{{ __('Month') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="k-portlet__foot">
                        <div class="k-form__actions">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                    <button type="reset" class="btn btn-secondary">{{__('Reset')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection
