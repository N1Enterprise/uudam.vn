<div class="section_settingValue" data-setting-key="{{ data_get($setting, 'key') }}">
    <span class="display_settingValue {{ !data_get($setting, 'value') ? 'text-secondary value-bordered' : '' }}" data-setting-key="{{ data_get($setting, 'key') }}">
        {{ data_get($setting, 'value') ? convert_datetime_to_client_time(data_get($setting, 'value'), false) : __('N/A') }}
    </span>
</div>
@can('system-settings.update')
<div class="section_settingAction w-100" data-setting-key="{{ data_get($setting, 'key') }}">
    <div class="input-group pull-right">
        <input
            type="datetimepicker"
            class="form-control"
            name="{{ data_get($setting, 'key') }}"
            placeholder="{{ __('Select') }} {{ __(data_get($setting, 'label')) }}"
            value="{{ convert_datetime_to_client_time(data_get($setting, 'value'), false) }}"
            id="{{ data_get($setting, 'key') }}"
            readonly
            data-origin="{{ convert_datetime_to_client_time(data_get($setting, 'value'), false) }}"
        >
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="la la-calendar-check-o"></i>
            </span>
        </div>
    </div>
</div>
@endcan
