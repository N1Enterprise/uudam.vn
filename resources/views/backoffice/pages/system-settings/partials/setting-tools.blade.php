@canany(['system-settings.create-key','system-settings.create-group'])
<div id="data_jsonGroup" data-groups="{{ json_encode($groups) }}"></div>
<div class="k-content__body	k-grid__item k-grid__item--fluid flex-grow-0">
    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Thiết lập hệ thống')}}
                </h3>
            </div>
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('system-settings.clear-cache')
                    <button id="btn_clearCache" type="button" class="btn btn-danger btn-bold btn-upper btn-font-sm">
                        <i class="flaticon2-trash"></i>
                        {{ __('Xóa bộ nhớ đệm') }}
                    </button>
                    @endcan

                    @can('system-settings.create-group')
                    <button id="btn_create_group" data-toggle="modal" data-target="#modal_storeGroup" class="btn btn-success btn-bold btn-upper btn-font-sm">
                        <i class="flaticon2-add-1"></i>
                        {{ __('Tạo nhóm') }}
                    </button>
                    @endcan

                    @can('system-settings.create-key')
                    <button id="btn_create_setting" data-toggle="modal" data-target="#modal_storeSettingKey" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="flaticon2-add-1"></i>
                        {{ __('Tạo cài đặt') }}
                    </button>
                    @endcan

                    @can('system-settings.import')
                    <button id="btn_import_setting" data-toggle="modal" data-target="#modal_importSettings" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-download"></i>
                        {{ __('Import Setting') }}
                    </button>
                    @endcan

                    @can('system-settings.export')
                    <button id="btn_export_setting" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-upload"></i>
                        {{ __('Export Setting') }}
                    </button>
                    @endcan
                </div>
            </div>
        </div>
        <div class="p-3">
            <input type="search" id="input_searchSystemSetting" class="form-control" placeholder="{{ __('Tìm kiếm cài đặt hệ thống') }}">
        </div>
    </div>
</div>
@endcanany

@include('backoffice.pages.system-settings.js-pages.setting-tools-script')

@push('modals')
@can('system-settings.create-group')
@include('backoffice.pages.system-settings.modals.create-group')
@endcan

@can('system-settings.create-key')
@include('backoffice.pages.system-settings.modals.create-setting')
@endcan

@can('system-settings.import')
@include('backoffice.pages.system-settings.modals.import-setting')
@endcan
@endpush
