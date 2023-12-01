@extends('backoffice.layouts.master')

@php

$title = __('Users');

$breadcrumbs = [
    [
        'label' => $title,
    ],
    [
        'label' => __('Search Users'),
        'href'  =>  route('bo.web.users.index')
    ],
    [
        'label' => __('Detail User'),
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
                @php $msg = 'The user was ' . __(session('actionMessage')); @endphp
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
                <div class="tab-pane active show" id="tab_general_information" role="tabpanel">
                    @include("backoffice.pages.users.partials.info")
                </div>

                @can('carts.index')
                <div class="tab-pane" id="tab_cart" role="tabpanel">
                    @include("backoffice.pages.users.partials.cart")
                </div>
                @endcan

                @can('orders.index')
                <div class="tab-pane" id="tab_order" role="tabpanel">
                    @include("backoffice.pages.users.partials.order")
                </div>
                @endcan
            </div>
        </div>

        <div class="col-lg-4 col-sm-4">
            <div class="k-portlet sticky-top" id="sticky-portlet" style="top: 100px;z-index: 1">
                <div class="k-portlet__body">
                    <div class="k-section" id="tabItemSection">
                        <div class="k-section__content">
                            <ul class="nav nav-tabs k-nav k-nav--v2 k-nav--lg-space k-nav--bold k-nav--lg-font" role="tablist">
                                <li class="k-nav__item k-nav__item--active">
                                    <a href="#tab_general_information" class="k-nav__link" data-toggle="tab" role="tab" aria-selected="true">
                                        <span class="k-nav__link-text">{{ __('General Information') }}</span>
                                    </a>
                                </li>

                                @can('carts.index')
                                <li class="k-nav__item">
                                    <a href="#tab_cart" class="k-nav__link" data-toggle="tab" role="tab"  data-tab="cart">
                                        <span class="k-nav__link-text">{{ __('Cart') }}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('orders.index')
                                <li class="k-nav__item">
                                    <a href="#tab_order" class="k-nav__link" data-toggle="tab" role="tab"  data-tab="order">
                                        <span class="k-nav__link-text">{{ __('Order') }}</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                    <div class="k-separator k-separator--border-dashed k-separator--height-xs"></div>
                    <div class="k-section__content action mt-4">
                        @if(! boolean($user->is_test_user))
                        <button type="button" data-modal="#modal_set_test_user" class="btn btn-outline-danger btn-block btn-pill btn-label-danger">{{ __('Mark as test account') }}</button>
                        @endif

                        @if($user->status == enum('ActivationStatusEnum')::ACTIVE)
                        <button action-url="{{ route('bo.web.users.action.deactivate', $user->id) }}" type-action="DEACTIVATE" class="actionBtn btn_user_action btn btn-outline-danger btn-block btn-pill btn-label-danger">{{ __('Deactivate') }}</button>
                        @elseif($user->status == enum('ActivationStatusEnum')::INACTIVE)
                        <button action-url="{{ route('bo.web.users.action.active', $user->id) }}" type-action="ACTIVE" class="actionBtn btn_user_action btn btn-outline-success btn-block btn-label-success btn-pill">{{ __('Activate') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@component('backoffice.partials.datatable') @endcomponent

@push('modals')
@if(! boolean($user->is_test_user))
<div class="modal fade" id="modal_set_test_user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Mark test account') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('bo.web.users.set-test-user', $user->id) }}">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __("Upon marking this as test accounts you're unable to revert the action, are you sure?") }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary" id="submitSetTestPlayer">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="modal_user_action" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_player_action" method="POST" action="">
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
                    <button type="submit" class="btn btn-primary" id="submitActionBtn">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script>
    onProcessUserAction();

    function onProcessUserAction() {
        let userActions = ($('.btn_user_action'));

        for (let i = 0; i < userActions.length; i++) {
            $(userActions[i]).on('click', (e) => {
                const sbUrl = e.target.attributes[0].value;
                const actionType = e.target.attributes[1].value

                $('#form_player_action').attr('action', `${sbUrl}`);
                $('#modal_user_action').find('.modal-title').text(`${e.target.innerHTML}`);
                $('#modal_user_action').modal('show');
                $('#form_player_action input:text[name="type"]').attr('value', actionType);
            });
        }
    }

    function reloadTable(element) {
        if (element && $(element).data('defer-loading') == true) {
            $(element).data('defer-loading', false);
            $(element).DataTable().ajax.reload(function(){});
        }
    }

    const TABPANEL_MANAGE = {
        init: () => {
            TABPANEL_MANAGE.onClickTabGeneral();
            TABPANEL_MANAGE.onClickTabCart();
            TABPANEL_MANAGE.onClickTabOrder();
        },
        onClickTabGeneral: () => {},
        onClickTabCart: () => {
            $('[data-tab="cart"]').on('click', function() {
                reloadTable('#table_carts_index');
            });
        },
        onClickTabOrder: () => {
            $('[data-tab="order"]').on('click', function() {
                reloadTable('#table_orders_index');
            });
        },
    };

    TABPANEL_MANAGE.init();

    $('#tabItemSection li.k-nav__item a.k-nav__link').on('click', function() {
        $('.k-nav__item').removeClass('k-nav__item--active');
        $(this).closest('li.k-nav__item').addClass('k-nav__item--active');
        window.scrollTo({ top: 0, behavior: 'auto' });
    });
</script>
@endsection
