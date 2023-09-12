@extends('backoffice.layouts.master')

@php
    $title = 'Users';

    $breadcrumbs = [
        [
            'label' => $title,
        ],
        [
            'label' => 'User Manage',
            'href'  =>  route('bo.web.users.index')
        ],
        [
            'label' => 'Detail User',
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
        <div class="col-lg-8 col-sm-8">
            @if (session('actionMessage'))
            <div class="alert alert-success fade show" role="alert">
                @php
                    $msg = 'The user was ' . __(session('actionMessage'));
                @endphp
                <div class="alert-text">{{ __($msg) }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="tab-content">
                <div class="tab-pane active show" id="generalInformationTab" role="tabpanel">
                    @include("backoffice.pages.users.partials.info")
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-4">
            <div class="k-portlet sticky-top" id="sticky-portlet" style="top: 100px;z-index: 1">
                <div class="k-portlet__body">
                    <div class="k-section" id="tabItemSection">
                        <div class="k-section__content">
                            <ul class="nav nav-tabs k-nav k-nav--v2 k-nav--lg-space k-nav--bold k-nav--lg-font" role="tablist">
                                @can('users.show')
                                <li class="k-nav__item k-nav__item--active">
                                    <a href="#generalInformationTab" class="k-nav__link" data-toggle="tab" role="tab"
                                        aria-selected="true">
                                        <span class="k-nav__link-text">{{ __('General Information') }}</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </div>

                    @can('users.action')
                    <div class="k-separator k-separator--border-dashed k-separator--height-xs"></div>

                    <div class="k-section__content action mt-4">
                        @can('users.set-test-user')
                            @if (!$user->is_test_user)
                            <button id="on_mark_as_test_account" class="btn btn-outline-danger btn-block btn-pill btn-label-danger">{{ __('Mark as test account') }}</button>
                            @endif
                        @endcan

                        @if ($user->status)
                        <button
                            class="user_action_item btn btn-outline-danger btn-block btn-pill btn-label-danger"
                            action-url="{{ route('bo.web.users.action.deactivate', ['id' => $user->id]) }}"
                            action-type="DEACTIVATE"
                        >{{ __('Deactivate') }}</button>
                        @else
                        <button
                            class="user_action_item btn btn-outline-success btn-block btn-label-success btn-pill"
                            action-url="{{ route('bo.web.users.action.active', ['id' => $user->id]) }}"
                            action-type="ACTIVE"
                        >{{ __('Activate') }}</button>
                        @endif

                        @if (!$user->banned)
                        <button
                            class="user_action_item btn btn-outline-dark btn-block btn-pill btn-label-dark"
                            action-url="{{ route('bo.web.users.action.ban', ['id' => $user->id]) }}"
                            action-type="BAN"
                        >{{ __('Ban') }}</button>
                        @else
                        <button
                            class="user_action_item btn btn-outline-brand btn-block btn-label-brand btn-pill"
                            action-url="{{ route('bo.web.users.action.unban', ['id' => $user->id]) }}"
                            action-type="UNBAN"
                        >{{ __('Remove Ban') }}</button>
                        @endif

                        <button
                            class="user_action_item text-danger btn btn-outline-hover-danger btn-block btn-pill"
                            action-url="{{ route('bo.web.users.action.kick', ['id' => $user->id]) }}"
                            action-type="KICK" id="kickBtn"
                            data-confirm="{{ __('Are you sure you want to kick this user ?') }}"
                        >{{ __('Kick User Session') }}</button>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_user_action" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_user_action" method="POST" action="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('Reason') }}</label>
                        <textarea name="reason" class="form-control" rows="10"></textarea>
                        <input type="text" name="type" value="" hidden>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@can('users.set-test-user')
<div id="modal_mark_as_test_account" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Mark test account') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_mark_as_test_account" method="POST" action="{{ route('bo.web.users.set-test-user', $user->id) }}">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>{{ __("Upon marking this as test accounts you're unable to revert the action, are you sure?") }}</label>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection

@section('js_script')
<script>
    const HANDLE_USER_ACTION = {
        init: () => {
            HANDLE_USER_ACTION.onMarkAsUserTest();
            HANDLE_USER_ACTION.onUserAction();
        },
        onMarkAsUserTest: () => {
            $('#on_mark_as_test_account').on('click', function() {
                $('#modal_mark_as_test_account').modal('show');
            });
        },
        onUserAction: () => {
            const actionUser = $('.action > .user_action_item');
            for (let i = 0; i < actionUser.length; i++) {
                $(actionUser[i]).on('click', (e) => {
                    const actionType = $(e.target).attr('action-type');
                    const actionUrl = $(e.target).attr('action-url');

                    $('#form_user_action').attr('action', `${actionUrl}`);
                    $('#modal_user_action').find('.modal-title').text(`${e.target.innerHTML}`);
                    $('#modal_user_action').modal('show');
                    $('#form_user_action input:text[name="type"]').attr('value', `${actionType}`);
                });
            }
        },
    };

    HANDLE_USER_ACTION.init();
</script>
@endsection
