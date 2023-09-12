<div class="section_settingValue" data-setting-key="{{ data_get($setting, 'key') }}">
    <span class="display_settingValue value-bordered text-uppercase {{ data_get($setting, 'value') == 1 ? 'text-success' : 'text-muted' }}" data-setting-key="{{ data_get($setting, 'key') }}">
        {{ data_get($setting, 'value') == 1 ? __('ON') : __('OFF') }}
    </span>
</div>
@can('system-settings.update')
<div class="section_settingAction" data-setting-key="{{ data_get($setting, 'key') }}">
    <span class="k-switch">
        <label class="mb-0">
            <input
                type="hidden"
                value="{{ old(data_get($setting, 'key'), data_get($setting, 'value') == 1 ? 'on' : 'off') }}"
                name="{{ data_get($setting, 'key') }}"
                id="{{ data_get($setting, 'key') }}"
            />
            <input
                class="switch-item"
                name="{{ data_get($setting, 'key') }}"
                data-setting-key="{{ data_get($setting, 'key') }}"
                data-origin="{{ data_get($setting, 'value') == 1 ? 'on' : 'off' }}"
                type="checkbox"
                {{ old(data_get($setting, 'key'), data_get($setting, 'value')) == 1 ? 'checked': '' }}
                id="{{data_get($setting, 'key')}}_checkbox"
            />
            <span></span>
        </label>
    </span>
</div>
@endcan
