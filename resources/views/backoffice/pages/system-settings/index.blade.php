@extends('backoffice.layouts.master')

@php
    $title = __('Quản lý hệ thống');

    $breadcrumbs = [
        [
            'label' => $title,
        ],
        [
            'label' => __('Thiết lập hệ thống'),
        ],
    ];
@endphp

@section('header')
{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent
@section('style')
<link href="{{ asset('backoffice/assets/vendors/custom/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
<style>
    .k-nav__link-text,
    .k-portlet__head-title,
    .col-form-label {
        text-transform: capitalize;
    }
    .k-nav__item--active i {
        color: white !important;
    }
    .section_settingValue {
        height: 100%;
        display: flex;
        align-items: center;
    }
    .section_settingAction {
        display: none;
    }
    .btn_editSetting.disabled {
        pointer-events: none;
    }
    .copyable_settingKey:hover {
        cursor: pointer;
    }
    .btn_editSetting:hover {
        cursor: pointer;
        text-decoration: underline;
    }
    .editable-buttons button {
        padding: 10px;
        margin-top: 4px;
    }
    .system-setting-item {
        min-height: 90px;
        padding: 10px 0;
    }
    .system-setting-item.json {
        align-items: center;
        padding: 25px 0;
    }
    .system-setting-item:not(:last-child) {
        border-bottom: 1px dashed #ebedf2;
    }
    .value-bordered {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 0.25rem;
    }
    .upload_image_custom_append_icon {
        top: 50%;
        right: 0;
        transform: translate(-6%, -50%);
        color: #4346ce!important;
        border: 1px solid #4346ce!important;
    }
    .note-toolbar-wrapper.panel-default {
        margin-bottom: 10px!important;
    }
    #form_builder_dom.styled {
        padding: 10px 35px;
        border: 1px solid #ebedf2;
        border-radius: 3px;
    }
    .ce-block__content,
    .ce-toolbar__content {
        max-width: unset!important;
    }
    .codex-editor__redactor {
        padding-bottom: 0px!important;
        min-height: 200px;
    }
</style>
@endsection

@section('content_body')
@include('backoffice.pages.system-settings.partials.setting-tools')
@can('system-settings.index')
<div class="k-content__body	k-grid__item k-grid__item--fluid">
    <div class="row">
        @include('backoffice.pages.system-settings.partials.setting-content')
        @include('backoffice.pages.system-settings.partials.setting-groups')
    </div>
</div>
@endcan
@endsection

@can('system-settings.update')
    <div class="section_editSystemSettingModal"></div>
@endcan

@section('js_script')
<script src="{{ asset('backoffice/assets/vendors/custom/bootstrap3-editable/js/bootstrap-editable.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.22.0/ace.js" type="text/javascript"></script>
@include('backoffice.pages.system-settings.js-pages.index-script')
@endsection
