<div class="section_settingValue" data-setting-key="{{ data_get($setting, 'key') }}">
    <span data-inputmask-display="{{ data_get($setting, 'key') }}" class="display_settingValue {{ !data_get($setting, 'value') ? 'text-secondary value-bordered' : '' }}" data-setting-key="{{ data_get($setting, 'key') }}">
        {{ data_get($setting, 'value') ? data_get($setting, 'value') : __('N/A') }}
    </span>
</div>
@can('system-settings.update')
<div class="section_settingAction w-100" data-setting-key="{{ data_get($setting, 'key') }}">
    <input
        min="0"
        value="{{ data_get($setting, 'value', 0) }}"
        name="{{ data_get($setting, 'key') }}"
        id="{{ data_get($setting, 'key') }}"
        class="form-control inputmask"
        data-origin="{{ data_get($setting, 'value') }}"
    >
</div>
@endcan
