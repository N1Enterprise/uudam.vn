@extends('backoffice.layouts.master')

@php
	$title = 'Roles';

	$breadcrumbs = [
		[
			'label' => $title,
            'href'  => route('bo.web.roles.index'),
		],
		[
			'label' => 'Create Role',
		]
	];
@endphp

@section('header')
    {{ __('Roles') }}
@endsection

@section('style')
<style>
    .permission-checkbox {
        display : inline-block;
    }
    .permission-navlink  {
        display : inline-block !important;

    }
    .k-nav__link.permission-navlink {
        padding-left: 0.4rem !important;
        margin-bottom: 0;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .custom.k-nav__item {
        margin-left : 1.8rem
    }
</style>
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
                        <h3 class="k-portlet__head-title">{{ __('Create Role') }}</h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form id="form_storeRole" class="k-form" method="post" action="{{ route('bo.web.roles.store') }}">
                    @csrf
                    <div class="k-portlet__body">
                        @include('backoffice.partials.message')

                        <div class="form-group">
                            <label>{{ __('Role Name') }} *</label>
                            <input type="text" class="form-control" name="name" placeholder="{{ __('Enter Role Name') }}" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <div class="k-section">
                                <label>{{ __('Permissions') }}</label>
                                <ul id="m_nav" class="k-nav k-nav--active-bg" role="tablist">
                                    <li class="k-nav__item custom">
                                        <span class="k-nav__link-bullet">
                                            <input class="permission-checkbox" type="checkbox" id="checkable_checkall" />
                                        </span>
                                        <label for="all" class="k-nav__link permission-navlink">
                                            <span class="k-nav__link-text">--{{ __('Select All') }}--</span>
                                        </label>
                                    </li>
                                    @foreach($groups as $key1 => $group1)
                                        @if(is_array($group1))
                                            @php
                                                if (empty($group1)) continue;
                                                $idKey1 = str_replace('.', '-', $key1);
                                            @endphp

                                            <li class="custom k-nav__item collapser">
                                                <span class="k-nav__link-bullet">
                                                    <input class="collapser-input" type="checkbox" parent-key="all" id="{{ $key1 }}" />
                                                </span>
                                                <a href="#co_{{ $idKey1 }}" class="k-nav__link permission-navlink collapsed" data-toggle="collapse">
                                                    <span class="k-nav__link-text">{{ __("backoffice::permissions.{$key1}") }}</span>
                                                    <span class="k-nav__link-arrow"></span>
                                                </a>
                                                <ul class="k-nav__sub collapse mt-2" id="co_{{ $idKey1 }}" role="tabpanel">
                                                @foreach($group1 as $key2 => $group2)
                                                    @if(is_array($group2))
                                                        @php
                                                            if (empty($group2)) continue;
                                                            $idKey2 = str_replace('.', '-', $key2);
                                                        @endphp

                                                        <li class="custom k-nav__item collapser">
                                                            <span class="k-nav__link-bullet">
                                                                <input class="collapser-input" type="checkbox" parent-key="{{ $key1 }}" id="{{ $key2 }}" />
                                                            </span>
                                                            <a href="#co_{{ $idKey2 }}" class="k-nav__link permission-navlink collapsed" data-toggle="collapse">
                                                                <span class="k-nav__link-text">{{ __("backoffice::permissions.{$key2}") }}</span>
                                                                <span class="k-nav__link-arrow"></span>
                                                            </a>
                                                            <ul class="k-nav__sub collapse mt-2" role="tabpanel" id="co_{{ $idKey2 }}">
                                                            @foreach($group2 as $key3 => $group3)
                                                                @if(is_array($group3))
                                                                    @php
                                                                        if (empty($group3)) continue;
                                                                        $idKey3 = str_replace('.', '-', $key3);
                                                                    @endphp

                                                                    <li class="custom k-nav__item collapser">
                                                                        <span class="k-nav__link-bullet">
                                                                            <input class="collapser-input" type="checkbox" parent-key="{{ $key2 }}" id="{{ $key3 }}" />
                                                                        </span>
                                                                        <a href="#co_{{ $idKey3 }}" class="k-nav__link permission-navlink collapsed" data-toggle="collapse">
                                                                            <span class="k-nav__link-text">{{ __("backoffice::permissions.{$key3}") }}</span>
                                                                            <span class="k-nav__link-arrow"></span>
                                                                        </a>
                                                                        <ul class="k-nav__sub collapse mt-2" role="tabpanel" id="co_{{ $idKey3 }}">
                                                                            @foreach($group3 as $key4 => $group4)
                                                                            <li class="custom k-nav__item">
                                                                                <input class="permission-checkbox" parent-key="{{ $key3 }}" name="permissions[{{ $group4 }}]" type="checkbox" id="{{ $group4 }}" />
                                                                                <label class="k-nav__link permission-navlink" style="cursor: pointer" for="{{ $group4 }}">
                                                                                    <span class="k-nav__link-text">{{ __("backoffice::permissions.{$group4}") }}</span>
                                                                                </label>
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                    @else
                                                                    <li class="custom k-nav__item">
                                                                        <input class="permission-checkbox" parent-key="{{ $key2 }}" name="permissions[{{ $group3 }}]" type="checkbox" id="{{ $group3 }}" />
                                                                        <label class="k-nav__link permission-navlink" style="cursor: pointer" for="{{ $group3 }}">
                                                                            <span class="k-nav__link-text">{{ __("backoffice::permissions.{$group3}") }}</span>
                                                                        </label>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                            </ul>
                                                        </li>
                                                    @else
                                                    <li class="custom k-nav__item">
                                                        <span class="k-nav__link-bullet">
                                                            <input class="permission-checkbox" name="permissions[{{ $group2 }}]" parent-key="{{ $key1 }}" type="checkbox" id="{{ $group2 }}" />
                                                        </span>
                                                        <label for="{{ $group2 }}" class="k-nav__link permission-navlink">
                                                            <span class="k-nav__link-text">{{ __("backoffice::permissions.{$group2}") }}</span>
                                                        </label>
                                                    </li>
                                                    @endif
                                                @endforeach
                                                </ul>
                                            </li>
                                        @else
                                        <li class="custom k-nav__item">
                                            <span class="k-nav__link-bullet">
                                                <input class="permission-checkbox" name="permissions[{{ $group1 }}]" parent-key="all" type="checkbox" id="{{ $group1 }}" />
                                            </span>
                                            <label for="{{ $group1 }}" class="k-nav__link permission-navlink">
                                                <span class="k-nav__link-text">{{ __("backoffice::permissions.{$group1}") }}</span>
                                            </label>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="k-portlet__foot">
                        <div class="k-form__actions">
                            <button type="redirect" class="btn btn-secondary">{{ __('Huỷ') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection

@section('js_script')
@include('backoffice.pages.roles.js-pages.create-script')
@endsection
