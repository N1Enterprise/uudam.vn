@php
$json = json_encode(data_get($setting, 'value'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
@endphp
<div
    class="section_settingValue json_editor mt-2"
    style="height: 200px"
    data-setting-key="{{ data_get($setting, 'key') }}"
    editor-id="{{ data_get($setting, 'key') }}"
    editor-editable="disabled"
></div>
<input
    disabled
    type="hidden"
    name="{{ data_get($setting, 'key') }}"
    value="{{ $json }}"
    editor-input="{{ data_get($setting, 'key') }}"
>
